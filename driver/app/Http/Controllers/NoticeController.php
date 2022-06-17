<?php

namespace App\Http\Controllers;

use App\Contracts\DriverContractInterface;
use App\Models\Notice;
use Illuminate\Support\Facades\DB;

class NoticeController extends Controller
{
    protected  int $limite = 10;
    private $driver = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(DriverContractInterface $driverService)
    {
        $this->driver = $driverService;
    }

//    public function get_notice() {
//        $notices = Notice::paginate($this->limite);
//        return  response()->json(['notices' => $notices]);
//    }
    public function  getNotices(): \Illuminate\Http\JsonResponse
    {
        return  response()->json(['notices' => $this->driver->getNotices()],200);
    }
    public function getNoticeById($id): \Illuminate\Http\JsonResponse
    {
        return response()->json(['notice' => $this->driver->getNoticeById($id)],200);
    }
}
