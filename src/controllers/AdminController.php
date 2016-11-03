<?php
namespace Vancels\Administrator;

use Auth;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Session\SessionManager as Session;
use Response;
use Symfony\Component\HttpFoundation\File\File as SFile;

/**
 * Handles all requests related to managing the data models
 */
class AdminController extends Controller
{

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Illuminate\Session\SessionManager
     */
    protected $session;

    /**
     * @var string
     */
    protected $formRequestErrors;

    /**
     * @var string
     */
    protected $layout = "administrator::layouts.default";

    /**
     * @param \Illuminate\Http\Request           $request
     * @param \Illuminate\Session\SessionManager $session
     */
    public function __construct(Request $request, Session $session)
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $admin = Auth::guard('admin')->user();

        return $admin->name;
    }

    /**
     * Shows the dashboard page
     *
     * @return Response
     */
    public function dashboard()
    {
        echo "ds";
    }

}
