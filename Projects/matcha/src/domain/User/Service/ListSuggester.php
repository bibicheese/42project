<?php

namespace Src\Domain\User\Service;

use Src\Domain\User\Data\UserAuth;
use Src\Domain\User\Repository\ListSuggesterRepository;

final class ListSuggester
{
    private $repository;

    public function __construct(ListSuggesterRepository $repository) {
        $this->repository = $repository;
    }

    public function getList($id) {
      if ($error = $this->repository->infoComplete($id))
        return ['error' => $error];
      
      else
        return $this->repository->displayList($id);
    }
}
