<?php
session_start();

require_once('tcpdf/tcpdf.php'); // Include the TCPDF library

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/// Initialize variables and retrieve data
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$net_savings = isset($_GET['net_savings']) ? $_GET['net_savings'] : '';
$highest_income = isset($_GET['highest_income']) ? $_GET['highest_income'] : 0;
$highest_expense = isset($_GET['highest_expense']) ? $_GET['highest_expense'] : 0;
$lowest_income = isset($_GET['lowest_income']) ? $_GET['lowest_income'] : 0;
$lowest_expense = isset($_GET['lowest_expense']) ? $_GET['lowest_expense'] : 0;
$average_income = isset($_GET['average_income']) ? $_GET['average_income'] : 0;
$average_expense = isset($_GET['average_expense']) ? $_GET['average_expense'] : 0;
$highest_income_source = isset($_GET['highest_income_source']) ? $_GET['highest_income_source'] : '';
$highest_expense_source = isset($_GET['highest_expense_source']) ? $_GET['highest_expense_source'] : '';
$lowest_income_source = isset($_GET['lowest_income_source']) ? $_GET['lowest_income_source'] : '';
$lowest_expense_source = isset($_GET['lowest_expense_source']) ? $_GET['lowest_expense_source'] : '';
$income_totalAmount=isset($_GET['income_totalAmount']) ? $_GET['income_totalAmount'] : '';
$expense_totalAmount=isset($_GET['expense_totalAmount']) ? $_GET['expense_totalAmount'] : '';
// Create a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Dashboard Report');
$pdf->SetSubject('Dashboard Statistics');
$pdf->SetKeywords('Dashboard, Statistics, PDF');

// Add a page
$pdf->AddPage();

// Add your content to the PDF (use HTML for formatting)
$html = '<h1>Dashboard Report</h1>';
$html .= '<p>Start Date: ' . $start_date . '</p>';
$html .= '<p>End Date: ' . $end_date . '</p>';
$html .= '<p>Total Savings: ' ."Rs.". $net_savings . '</p>';

// Add a table for highest income and expense data
$html .= '<h2>Highest Income and Expense</h2>';
$html .= '<table border="1">';
$html .= '<tr><th>Category</th><th>Amount</th></tr>';
$html .= '<tr><td>Highest Income</td><td>'. $highest_income_source .": " ."Rs.". $highest_income . '</td></tr>';
$html .= '<tr><td>Highest Expense</td><td>'. $highest_expense_source .": "."Rs." . $highest_expense . '</td></tr>';
$html .= '</table>';

// Add a table for lowest income and expense data
$html .= '<h2>Lowest Income and Expense</h2>';
$html .= '<table border="1">';
$html .= '<tr><th>Category</th><th>Amount</th></tr>';
$html .= '<tr><td>Lowest Income</td><td>'. $lowest_income_source .": "."Rs." . $lowest_income . '</td></tr>';
$html .= '<tr><td>Lowest Expense</td><td>' . $lowest_expense_source .":"."Rs.". $lowest_expense . '</td></tr>';
$html .= '</table>';

// Add a table for average income and expense data
$html .= '<h2>Average Income and Expense</h2>';
$html .= '<table border="1">';
$html .= '<tr><th>Category</th><th>Amount</th></tr>';
$html .= '<tr><td>Average Income</td><td>'."Rs." . number_format($average_income, 2) . '</td></tr>';
$html .= '<tr><td>Average Expense</td><td>' ."Rs.". number_format($average_expense, 2) . '</td></tr>';
$html .= '</table>';

//Add a table for total income and expense data
$html .= '<h2>Total Income and Expense</h2>';
$html .= '<table border="1">';
$html .= '<tr><th>Total Income</th><th>Total Expense</th></tr>';
$html .= '<tr><td>'."Rs.".$income_totalAmount.'</td><td>'."Rs.".$expense_totalAmount.'</td></tr>';
$html .= '</table>';
// Output the HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF as a downloadable file
$pdf->Output('dashboard_report.pdf', 'D');

// Exit the script
exit();
?>