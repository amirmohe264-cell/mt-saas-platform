<?php

/**
 * Email Helper Functions
 * Location: app/Helpers/email_helper.php
 */

if (!function_exists('sendOrderConfirmation')) {
    function sendOrderConfirmation($customerEmail, $orderData)
    {
        $email = \Config\Services::email();
        
        $email->setTo($customerEmail);
        $email->setSubject('Order Confirmation - ShopEase');
        
        $message = "Thank you for your order!\n\n";
        $message .= "Order #: " . $orderData['order_number'] . "\n";
        $message .= "Total: $" . number_format($orderData['total_amount'], 2) . "\n";
        $message .= "Status: " . ucfirst($orderData['order_status'] ?? 'Pending') . "\n\n";
        $message .= "You will receive a confirmation once your order is processed.\n\n";
        $message .= "Thank you for shopping with ShopEase!";
        
        $email->setMessage($message);
        
        return $email->send();
    }
}

if (!function_exists('sendOrderStatusUpdate')) {
    function sendOrderStatusUpdate($customerEmail, $orderNumber, $status)
    {
        $email = \Config\Services::email();
        
        $email->setTo($customerEmail);
        $email->setSubject('Order Status Update - ShopEase');
        
        $message = "Your order #" . $orderNumber . " has been updated.\n\n";
        $message .= "New Status: " . ucfirst($status) . "\n\n";
        $message .= "Thank you for shopping with ShopEase!";
        
        $email->setMessage($message);
        
        return $email->send();
    }
}