<?php
header('Content-Type: application/json; charset=utf-8');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit; }
if (!empty($_POST['website_hp'])) { echo json_encode(['status' => 'ok']); exit; }
function clean_val($v) { return htmlspecialchars(strip_tags(trim($v ?? '')), ENT_QUOTES, 'UTF-8'); }
function one_line($v) { return preg_replace('/\s+/u', ' ', $v); }
$urgent  = clean_val($_POST['is_emergency'] ?? '0') === '1' ? 'URGENT' : 'NORMAL';
$name    = clean_val($_POST['full_name'] ?? '');
$biz     = clean_val($_POST['business_name'] ?? '');
$url     = clean_val($_POST['site_url'] ?? '');
$method  = clean_val($_POST['contact_method'] ?? '');
$contact = clean_val($_POST['contact_info'] ?? '');
$service = clean_val($_POST['service_type'] ?? '');
$status  = clean_val($_POST['site_status'] ?? '');
$role    = clean_val($_POST['decision_role'] ?? '');
$urgency = clean_val($_POST['urgency'] ?? '');
$desc    = clean_val($_POST['problem_desc'] ?? '');
$date    = date('Y-m-d H:i:s');

$to = "info@farta.ir";
$subject = "[$urgent] Farta Lead: " . one_line($biz);
$body = "Mode: $urgent\nName: $name\nBusiness: $biz\nSite: $url\nContact: $method ($contact)\nService: $service\nStatus: $status\nRole: $role\nUrgency: $urgency\nDesc:\n$desc\nDate: $date\n";
$headers = "From: noreply@farta.ir\r\nContent-Type: text/plain; charset=UTF-8\r\n";
@mail($to, $subject, $body, $headers);
@file_put_contents(__DIR__ . '/.farta_leads.log', "[$date] | $urgent | " . one_line("$name | $biz | $url | $contact | $service") . "\n", FILE_APPEND | LOCK_EX);
echo json_encode(['status' => 'success']);