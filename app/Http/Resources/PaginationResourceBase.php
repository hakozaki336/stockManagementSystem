<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;
use stdClass;

/**
 * ページネーションリソースの基底クラス
 */
class PaginationResourceBase extends ResourceCollection
{
    public function __construct(LengthAwarePaginator $resource)
    {
        parent::__construct($resource);
    }

    public function with(Request $request)
    {
        return [
            'links' => [
                'current' => $this->resource->url($this->resource->currentPage()),
            ],
        ];
    }

    /**
     * 親クラスのtoResponse をオーバーライド
     * MEMO: ※不要な情報を削除するため
     */
    public function toResponse($request)
    {
        $responseData = parent::toResponse($request)->getData();

        $this->removeMeta($responseData);
        $this->removeLinks($responseData);

        return $responseData;
    }

    /**
     * 不要なMeta情報を削除する
     */
    private function removeMeta(stdClass $responseData): stdClass
    {
        unset($responseData->meta);

        return $responseData;
    }

    /**
     * 不要なlinksの情報を削除する
     */
    private function removeLinks(stdClass $responseData): stdClass
    {
        unset($responseData->links->first);
        unset($responseData->links->last);

        return $responseData;
    }
}
