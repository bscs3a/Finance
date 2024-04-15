<?php
require_once "../generalFunctions.php";
require_once "../supportingFunctions/tax.php";


// parameters is SalesAmount(without tax and without discount)
// taxAmount 
// salesPaymentMethod(what is being used for salesPayment) -- options are "Cash on hand" "Cash on bank"
// taxPaymentMethod is usually with Tax Payable, can be change to your discretion, but dont if possible
// discount is the amount of discount given,
function insertSalesLedger($salesAmount,$taxAmount, $salesPaymentMethod, $taxPaymentMethod = "Tax Payable", $discount = 0){
    if ($salesAmount <= 0 || $taxAmount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($salesPaymentMethod === "Cash on hand" || $salesPaymentMethod === "Cash on bank" ){
        throw new Exception("Payment method for sales is wrong");
    }
    if($taxPaymentMethod === "Cash on hand" || $taxPaymentMethod === "Cash on bank" || $taxPaymentMethod === "Tax Payable"){
        throw new Exception("Payment method for tax is wrong");
    }
    if($discount < 0){
        throw new Exception("Discount cannot be negative");
    }
    $SALES =  "Sales";
    $salesDetails = "made a sale";
    $taxDetails = "VAT";
    insertLedgerXact($salesPaymentMethod, $SALES, $salesAmount, $salesDetails);
    insertTax($taxPaymentMethod, $taxAmount, $taxDetails);

    //for discount
    if ($discount > 0){
        $DISCOUNT = "Discount";
        $discountDetails = "Discount given";
        insertLedgerXact($DISCOUNT, $salesPaymentMethod, $discount, $discountDetails);
    }
}

//for full return
//amount is the amount you are refunding
//paymentMethod can be "Cash on hand" or "Cash on bank"
function insertSalesReturn($amount, $paymentMethod){
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($paymentMethod === "Cash on hand" || $paymentMethod === "Cash on bank"){
        throw new Exception("Payment method cannot be null");
    }
    $SALES_RETURN = "Returns";
    $details = "Sales return";
    insertLedgerXact($SALES_RETURN, $paymentMethod, $amount, $details);
}

// for allowance
//amount is the amount you are refunding
//paymentMethod can be "Cash on hand" or "Cash in bank"
function insertSalesAllowance($amount, $paymentMethod){
    if ($amount <= 0){
        throw new Exception("Amount must be greater than 0");
    }
    if($paymentMethod === "Cash on hand" || $paymentMethod === "Cash on bank"){
        throw new Exception("Payment method cannot be null");
    }
    $SALES_ALLOWANCE = "Allowance";
    $details = "Sales allowance";
    insertLedgerXact($SALES_ALLOWANCE, $paymentMethod, $amount, $details);
}
?>