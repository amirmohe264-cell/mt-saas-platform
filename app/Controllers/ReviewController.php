<?php

namespace App\Controllers;

use App\Models\ReviewModel;

class ReviewController extends BaseController
{
    protected $reviewModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
    }

    public function check($productId)
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if (!$customerId) {
            return $this->response->setJSON([
                'success' => true,
                'logged_in' => false,
                'can_review' => false
            ]);
        }

        $hasPurchased = $this->reviewModel->hasPurchased($customerId, $productId);
        $existing = $this->reviewModel
            ->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

        return $this->response->setJSON([
            'success' => true,
            'logged_in' => true,
            'can_review' => $hasPurchased,
            'existing_review' => $existing
        ]);
    }

    public function submit()
    {
        $customerId = session()->get('customer_id') ?? session()->get('user_id');

        if (!$customerId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Please login first'
            ]);
        }

        $input = $this->request->getJSON(true);
        $productId = $input['product_id'] ?? null;
        $rating = $input['rating'] ?? null;
        $title = $input['review_title'] ?? null;
        $comment = $input['review_comment'] ?? null;

        if (!$productId || !$rating) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Product and rating are required'
            ]);
        }

        if ($rating < 1 || $rating > 5) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Rating must be between 1 and 5'
            ]);
        }

        if (!$this->reviewModel->hasPurchased($customerId, $productId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You can only rate products you have purchased and received.'
            ]);
        }

        $existing = $this->reviewModel
            ->where('customer_id', $customerId)
            ->where('product_id', $productId)
            ->first();

        $data = [
            'product_id' => $productId,
            'customer_id' => $customerId,
            'rating' => $rating,
            'review_title' => $title,
            'review_comment' => $comment,
            'is_approved' => false,
        ];

        if ($existing) {
            $this->reviewModel->update($existing['id'], $data);
            $message = 'Your review has been updated and is pending approval.';
        } else {
            $this->reviewModel->insert($data);
            $message = 'Thank you! Your review has been submitted and is pending approval.';
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => $message
        ]);
    }
}