<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'layout';

$route['suppliers'] = 'suppliers_ctrl';
$route['suppliers/(:any)'] = 'suppliers_ctrl/$1';
$route['suppliers/(:any)/(:any)'] = 'suppliers_ctrl/$1/$2';

$route['brands'] = 'brand_ctrl';
$route['brands/(:any)'] = 'brand_ctrl/$1';
$route['brands/(:any)/(:any)'] = 'brand_ctrl/$1/$2';


$route['product-category'] = 'product_category_ctrl';
$route['product-category/(:any)'] = 'product_category_ctrl/$1';
$route['product-category/(:any)/(:any)'] = 'product_category_ctrl/$1/$2';

$route['unit'] = 'unit_ctrl';
$route['unit/(:any)'] = 'unit_ctrl/$1';
$route['unit/(:any)/(:any)'] = 'unit_ctrl/$1/$2';


$route['products'] = 'product_ctrl';
$route['products/(:any)'] = 'product_ctrl/$1';
$route['products/(:any)/(:any)'] = 'product_ctrl/$1/$2';

$route['purchase'] = 'purchase_ctrl';
$route['purchase/(:any)'] = 'purchase_ctrl/$1';
$route['purchase/(:any)/(:any)'] = 'purchase_ctrl/$1/$2';

$route['purchase-return'] = 'purchase_return_ctrl';
$route['purchase-return/(:any)'] = 'purchase_return_ctrl/$1';
$route['purchase-return/(:any)/(:any)'] = 'purchase_return_ctrl/$1/$2';

$route['sales'] = 'sales_ctrl';
$route['sales/(:any)'] = 'sales_ctrl/$1';
$route['sales/(:any)/(:any)'] = 'sales_ctrl/$1/$2';

$route['sales-return'] = 'sales_return_ctrl';
$route['sales-return/(:any)'] = 'sales_return_ctrl/$1';
$route['sales-return/(:any)/(:any)'] = 'sales_return_ctrl/$1/$2';

$route['customer'] = 'customer_ctrl';
$route['customer/(:any)'] = 'customer_ctrl/$1';
$route['customer/(:any)/(:any)'] = 'customer_ctrl/$1/$2';

$route['company-details'] = 'company_details_ctrl';
$route['company-details/(:any)'] = 'company_details_ctrl/$1';
$route['company-details/(:any)/(:any)'] = 'company_details_ctrl/$1/$2';



$route['login'] = 'login_Ctrl';
$route['login/(:any)'] = 'login_Ctrl/$1';

$route['expense'] = 'expense_ctrl';
$route['expense/(:any)'] = 'expense_ctrl/$1';
$route['expense/(:any)/(:any)'] = 'expense_ctrl/$1/$2';

$route['reports'] = 'reports_ctrl';
$route['reports/(:any)'] = 'reports_ctrl/$1';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;