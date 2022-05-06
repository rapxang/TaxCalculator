<?php
	$grossIncome = filter_input(INPUT_POST, 'grossIncome',
        FILTER_VALIDATE_FLOAT);

    $state = filter_input(INPUT_POST, 'formGender',
        FILTER_VALIDATE_FLOAT);
    // validate grossIncome
    if ($grossIncome === FALSE ) {
        $error_message = 'Investment must be a valid number.'; 
    }
    else if ($grossIncome < 1000 ) {
        $error_message = 'Investment must be at least or greater than Rs. 1,000.'; 
    }
    else if ($_POST["formGender"] == FALSE && $_POST["formState"] == FALSE) {
        $error_message = 'Select your Marital Status and Gender'; 
    }
    else if ($_POST["formGender"] == TRUE && $_POST["formState"] == FALSE) {
        $error_message = 'Select your Marital Status'; 
    }
    else if ($_POST["formGender"] == FALSE && $_POST["formState"] == TRUE) {
        $error_message = 'Select your Gender'; 
    }
    
    // set error message to empty string if no invalid entries
    else {
        $error_message = ''; 
    }

     // if an error message exists, go to the form page
    if ($error_message != '') {
        include('taxcalculator.php');
        exit(); 
    }

    // calculations 

    // calculate taxable income, which is gross income minus 10,000
	$taxableIncome = $grossIncome - 0;
	/* use conditionals to decide tax rate, perform computation to get
	total income tax */
    if ($_POST["formGender"] == "Male" && $_POST["formState"] == "Married") {
        if ($taxableIncome <= 450000) {
            $totalIncomeTax = ($taxableIncome * 1) / 100;
        }
        elseif ($taxableIncome >= 450001 && $taxableIncome <= 550000) {
            $totalIncomeTax = ((($taxableIncome - 450000) * 10) / 100) + 4500;
        }
        elseif ($taxableIncome >= 550001 && $taxableIncome <= 750000) {
            $totalIncomeTax = ((($taxableIncome - 550000) * 20) / 100) + 14500;
        }
        elseif ($taxableIncome >= 750001 && $taxableIncome <= 2000000) {
            $totalIncomeTax = ((($taxableIncome - 750000) * 30) / 100) + 54500; 
        }
        else {
            $totalIncomeTax = ((($taxableIncome - 2000000) * 36) / 100) + 429500;
        }
    }
    elseif ($_POST["formGender"] == "Male" && $_POST["formState"] == "Unmarried") {
        if ($taxableIncome <= 400000) {
            $totalIncomeTax = ($taxableIncome * 1) / 100;
        }
        elseif ($taxableIncome >= 400001 && $taxableIncome <= 500000) {
            $totalIncomeTax = ((($taxableIncome - 400000) * 10) / 100) + 4000;
        }
        elseif ($taxableIncome >= 500001 && $taxableIncome <= 700000) {
            $totalIncomeTax = ((($taxableIncome - 500000) * 20) / 100) + 14000;
        }
        elseif ($taxableIncome >= 700001 && $taxableIncome <= 2000000) {
            $totalIncomeTax = ((($taxableIncome - 700000) * 30) / 100) + 54000; 
        }
        else {
            $totalIncomeTax = ((($taxableIncome - 2000000) * 36) / 100) + 444000;
        }
    }
    elseif ($_POST["formGender"] == "Female" && $_POST["formState"] == "Married") {
        if ($taxableIncome <= 450000) {
            $totalIncomeTax = ($taxableIncome * 1) / 100;
        }
        elseif ($taxableIncome >= 450001 && $taxableIncome <= 550000) {
            $totalIncomeTax = ((($taxableIncome - 450000) * 10) / 100) + 4500;
        }
        elseif ($taxableIncome >= 550001 && $taxableIncome <= 750000) {
            $totalIncomeTax = ((($taxableIncome - 550000) * 20) / 100) + 14500;
        }
        elseif ($taxableIncome >= 750001 && $taxableIncome <= 2000000) {
            $totalIncomeTax = ((($taxableIncome - 750000) * 30) / 100) + 54500; 
        }
        else {
            $totalIncomeTax = ((($taxableIncome - 2000000) * 36) / 100) + 429500;
        }
    }
    else {
        if ($taxableIncome <= 400000) {
            $totalIncomeTax = ($taxableIncome * 1) / 100;
        }
        elseif ($taxableIncome >= 400001 && $taxableIncome <= 500000) {
            $totalIncomeTax = ((($taxableIncome - 400000) * 10) / 100) + 4000;
        }
        elseif ($taxableIncome >= 500001 && $taxableIncome <= 700000) {
            $totalIncomeTax = ((($taxableIncome - 500000) * 20) / 100) + 14000;
        }
        elseif ($taxableIncome >= 700001 && $taxableIncome <= 2000000) {
            $totalIncomeTax = ((($taxableIncome - 700000) * 30) / 100) + 54000; 
        }
        else {
            $totalIncomeTax = ((($taxableIncome - 2000000) * 36) / 100) + 444000;
        }
    }

	// calculate effectiveTaxRate and store 
	$effectiveTaxRate = $totalIncomeTax / $grossIncome;
	$effectiveTaxRate *= 100;
	$effectiveTaxRate = round($effectiveTaxRate, 1); //round to 1 place after decimal

    // apply formatting

	$grossIncome_f = number_format($grossIncome);
	$taxableIncome_f = number_format($taxableIncome);
	$totalIncomeTax_f = number_format($totalIncomeTax, 2);
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta charset="utf-8" />
	<title> Income Tax </title>
	<link rel="stylesheet" type="text/css" href="main.css">
</head>
<body>
	<main> 
		<h1> Tax Calculator </h1> 
		<?php
		echo "As a " . $_POST["formGender"] . " " . $_POST["formState"] . " taxpayer with a gross annual income of Rs. " . $grossIncome_f
			 . ", your taxable income is Rs. " . $taxableIncome_f . ".";
			
		$newline = "\n";     // create a newline in php with these 2 lines
		echo nl2br($newline);
		$newline = "\n";     // creating another newline 
		echo nl2br($newline);
			
		echo "Your total income tax is Rs. " . $totalIncomeTax_f;
	    ?>
        <br>
        <button class="button"><a href="taxcalculator.php">Go Back</a></button>
	</main>
</body>
</html>
