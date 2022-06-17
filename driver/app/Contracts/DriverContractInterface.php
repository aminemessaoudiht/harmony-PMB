<?php
namespace App\Contracts;

interface DriverContractInterface
{
    public function config( string $name );
    public function getNotices();
    public function getNoticeById(int $id);
    public function getNoticesByAuthor(int $id);
    public function getNoticesByPublisher(int $id);
    public function getNoticesByIndex(int $id);
}
