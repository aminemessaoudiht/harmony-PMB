<?php

namespace App\Services;


use App\Contracts\DriverContractInterface;
use App\Models\Pmb\Notice;

class PmbDriverService implements  DriverContractInterface
{
    private $limite = 10;

    public function config($name){
        dd('Bienvenues test pmb');
    }

    public function getNotices()
    {
        return Notice::paginate($this->limite);
    }

    public function getNoticeById($id)
    {
        return Notice::where('notice_id', $id)->get();
    }

    public function getNoticesByAuthor(int $id)
    {
        // TODO: Implement getNoticesByAuthor() method.
    }

    public function getNoticesByPublisher(int $id)
    {
        // TODO: Implement getNoticesByPublisher() method.
    }

    public function getNoticesByIndex(int $id)
    {
        // TODO: Implement getNoticesByIndex() method.
    }
}
