<?php

namespace App\Http\Controllers;

use App\Contracts\DriverContractInterface;
use App\Models\Pmb\Notice;
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

    public function  getNotices(): \Illuminate\Http\JsonResponse
    {
        return  response()->json(['notices' => $this->driver->getNotices()],200);
    }
    public function getNoticeById($id): \Illuminate\Http\JsonResponse
    {
        return response()->json(['notice' => $this->driver->getNoticeById($id)],200);
    }

}
