<?php


namespace App\Services;

use App\Contracts\DriverContractInterface;
use App\Models\Doc;

class KohaDriverService implements  DriverContractInterface
{
    private $limite = 10;

    public function config($name){
        dd('Bienvenues test koha');
    }

    public function getNotices()
    {
        return Doc::paginate($this->limite);
    }

    public function getNoticeById(int $id)
    {
        return Doc::where('doc_id', $id)->get();
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
