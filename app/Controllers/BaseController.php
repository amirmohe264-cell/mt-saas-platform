<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Load here all helpers you want to be available in your controllers that extend BaseController.
        // Caution: Do not put the this below the parent::initController() call below.
        // $this->helpers = ['form', 'url'];

        // Caution: Do not edit this line.
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        // $this->session = service('session');
    }

    /**
     * ✅ Check if user is logged in
     * 
     * @return bool
     */
    protected function isLoggedIn()
    {
        $session = service('session');
        return $session->get('user_id') !== null && !empty($session->get('user_id'));
    }

    /**
     * ✅ Get current user role
     * 
     * @return string
     */
    protected function getUserRole()
    {
        $session = service('session');
        return $session->get('role') ?? 'guest';
    }

    /**
     * ✅ Get current user ID
     * 
     * @return int|null
     */
    protected function getUserId()
    {
        $session = service('session');
        return $session->get('user_id') ?? null;
    }

    /**
     * ✅ Get current tenant ID (for store owners)
     * 
     * @return int|null
     */
    protected function getTenantId()
    {
        $session = service('session');
        return $session->get('tenant_id') ?? null;
    }

    /**
     * ✅ Get user name
     * 
     * @return string
     */
    protected function getUserName()
    {
        $session = service('session');
        return $session->get('user_name') ?? '';
    }

    /**
     * ✅ Get user email
     * 
     * @return string
     */
    protected function getUserEmail()
    {
        $session = service('session');
        return $session->get('user_email') ?? '';
    }

    /**
     * ✅ Get dashboard URL based on user role
     * 
     * @return string
     */
    protected function getDashboardUrl()
    {
        $role = $this->getUserRole();
        
        switch ($role) {
            case 'super_admin':
                return '/admin/dashboard';
            case 'store_owner':
                return '/store/dashboard';
            case 'customer':
            default:
                return '/dashboard';
        }
    }

    /**
     * ✅ Get dashboard label based on user role
     * 
     * @return string
     */
    protected function getDashboardLabel()
    {
        $role = $this->getUserRole();
        
        switch ($role) {
            case 'super_admin':
                return 'Admin Dashboard';
            case 'store_owner':
                return 'Store Dashboard';
            case 'customer':
            default:
                return 'My Dashboard';
        }
    }

    /**
     * ✅ Get dashboard icon based on user role
     * 
     * @return string
     */
    protected function getDashboardIcon()
    {
        $role = $this->getUserRole();
        
        switch ($role) {
            case 'super_admin':
                return 'fa-crown';
            case 'store_owner':
                return 'fa-store';
            case 'customer':
            default:
                return 'fa-user';
        }
    }

    /**
     * ✅ Override view method to pass session data automatically
     * 
     * @param string $view
     * @param array $data
     * @return void
     */
    protected function view($view, $data = [])
    {
        $session = service('session');
        
        // Add session data to all views
        $data['is_logged_in'] = $this->isLoggedIn();
        $data['user_role'] = $this->getUserRole();
        $data['user_id'] = $this->getUserId();
        $data['tenant_id'] = $this->getTenantId();
        $data['user_name'] = $this->getUserName();
        $data['user_email'] = $this->getUserEmail();
        
        // Add role-specific dashboard info
        $data['dashboard_url'] = $this->getDashboardUrl();
        $data['dashboard_label'] = $this->getDashboardLabel();
        $data['dashboard_icon'] = $this->getDashboardIcon();
        
        // Extract data and load view
        extract($data);
        
        // Get the view path
        $viewPath = "../app/Views/{$view}.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View file not found: {$viewPath}");
        }
        
        require_once $viewPath;
    }

    /**
     * ✅ Redirect helper
     * 
     * @param string $url
     * @return void
     */
    protected function redirect($url)
    {
        header("Location: {$url}");
        exit;
    }

    /**
     * ✅ Redirect with message
     * 
     * @param string $url
     * @param string $message
     * @param string $type (success, error, warning, info)
     * @return void
     */
    protected function redirectWithMessage($url, $message, $type = 'success')
    {
        $session = service('session');
        $session->setFlashdata('message', $message);
        $session->setFlashdata('message_type', $type);
        $this->redirect($url);
    }

    /**
     * ✅ Get flash message
     * 
     * @return array|null
     */
    protected function getFlashMessage()
    {
        $session = service('session');
        $message = $session->getFlashdata('message');
        $type = $session->getFlashdata('message_type') ?? 'info';
        
        if ($message) {
            return [
                'message' => $message,
                'type' => $type
            ];
        }
        return null;
    }

    /**
     * ✅ Require login (redirect if not logged in)
     * 
     * @param string $redirectUrl
     * @return void
     */
    protected function requireLogin($redirectUrl = '/login')
    {
        if (!$this->isLoggedIn()) {
            $this->redirectWithMessage($redirectUrl, 'Please login to access this page.', 'error');
        }
    }

    /**
     * ✅ Require specific role
     * 
     * @param string|array $roles
     * @param string $redirectUrl
     * @return void
     */
    protected function requireRole($roles, $redirectUrl = '/dashboard')
    {
        $this->requireLogin($redirectUrl);
        
        if (!is_array($roles)) {
            $roles = [$roles];
        }
        
        if (!in_array($this->getUserRole(), $roles)) {
            $this->redirectWithMessage($redirectUrl, 'You do not have permission to access this page.', 'error');
        }
    }

    /**
     * ✅ Require store owner
     * 
     * @param string $redirectUrl
     * @return void
     */
    protected function requireStoreOwner($redirectUrl = '/dashboard')
    {
        $this->requireRole('store_owner', $redirectUrl);
    }

    /**
     * ✅ Require admin
     * 
     * @param string $redirectUrl
     * @return void
     */
    protected function requireAdmin($redirectUrl = '/dashboard')
    {
        $this->requireRole('super_admin', $redirectUrl);
    }

    /**
     * ✅ Require customer
     * 
     * @param string $redirectUrl
     * @return void
     */
    protected function requireCustomer($redirectUrl = '/dashboard')
    {
        $this->requireRole('customer', $redirectUrl);
    }

    /**
     * ✅ Check if user is customer
     * 
     * @return bool
     */
    protected function isCustomer()
    {
        return $this->getUserRole() === 'customer';
    }

    /**
     * ✅ Check if user is store owner
     * 
     * @return bool
     */
    protected function isStoreOwner()
    {
        return $this->getUserRole() === 'store_owner';
    }

    /**
     * ✅ Check if user is admin
     * 
     * @return bool
     */
    protected function isAdmin()
    {
        return $this->getUserRole() === 'super_admin';
    }
}