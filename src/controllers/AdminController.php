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

        $this->request = $request;
        $this->session = $session;

        if (!is_null($this->layout)) {
            $this->layout = view($this->layout);

            $this->layout->page      = false;
            $this->layout->dashboard = false;
        }
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
        $admin = Auth::guard('admin')->user();
        echo "ds";

        return $admin->name;
    }

}
