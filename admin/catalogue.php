<?php
include '../api/db-access.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

require_once('../plugins/TCPDF-master/tcpdf.php');


/******* GATHERING PDF DATA *********/


$productList = $db->displayAllProducts($_SESSION["WebsiteID"]);
$categoryList = $db->getCategories($_SESSION["WebsiteID"]);

/******* PDF WRITE HERE: ********/



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle($_SESSION["WebsiteDetails"]["DomainName"] . " Catagloue");
$pdf->SetSubject('Catalogue of Products');

// set default header data
$pdf->SetHeaderData(null, 0, $_SESSION["WebsiteDetails"]["DomainName"] . " Catagloue", null, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('dejavusans', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));


// Set some content to print
$html = <<<EOD

EOD;

$html .='<style>
h1 {
   background-color: #3D3BAE;
   color: white;
   text-align: center;
}
</style>';

// Get list of categories
while($row = $categoryList->fetch_assoc()){
    // Get list of sub category for the category
    $subCategoryList = $db->getSubCategories($row["Title"], $_SESSION["WebsiteID"]);  
   
    while($subCatRow = $subCategoryList->fetch_assoc()){
        
        // Get list of produts for the sub category
        $productList = $db->getProductBySubCategory($_SESSION["WebsiteID"], $row["Title"], $subCatRow["SubCategory"]);
        
        if($productList->num_rows > 0){
            $html .= "<h1>" . $subCatRow["SubCategory"] . "</h1>";
            while($productRow = $productList->fetch_assoc()){
                $html .= '<img src="../sites/' . $_SESSION['WebsiteDetails']['DomainName'] .'/img/items/'. $productRow["ProductID"] . '.jpg" width="250px" height="auto">';
                $html .= "<h3>" . $productRow["Name"] . "</h3>";
                $html .= "<p> &pound;" . $productRow["Price"] . "</p>";
            }
        }
    }
}

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>