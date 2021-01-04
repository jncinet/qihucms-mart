<?php

namespace Qihucms\Mart\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Qihucms\Mart\Repositories\MartRepository;
use Qihucms\Mart\Requests\MartRequest;
use Qihucms\Mart\Resources\Mart as MartResource;
use Qihucms\Mart\Resources\MartCollection;

class MartController extends Controller
{
    protected $mart;

    public function __construct(MartRepository $martRepository)
    {
        $this->mart = $martRepository;
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * 后台AJAX查询店铺
     *
     * @param Request $request
     * @return mixed
     */
    public function adminGetMartByQ(Request $request)
    {
        $keyword = $request->get('q', '');

        return $this->mart->adminGetMartPaginate($keyword);
    }

    /**
     * 店铺列表
     *
     * @param Request $request
     * @return MartCollection
     */
    public function index(Request $request)
    {
        $orderBy = ['user_id' => 'desc'];

        // 关键词搜索
        $kw = $request->get('kw');

        // 根据等级排序
        if ($request->has('exp')) {
            $orderBy = array_merge(['exp' => $request->get('exp', 'desc')], $orderBy);
        }

        return new MartCollection(
            $this->mart->getMartPaginate($kw, $orderBy, $request->get('limit', 15))
        );
    }

    /**
     * 开通店铺或更新店铺资料
     *
     * @param MartRequest $request
     * @return \Illuminate\Http\JsonResponse|MartResource
     */
    public function store(MartRequest $request)
    {
        $user = Auth::user();

        $mart_slug = config('qihu.mart_slug');

        // 如果开通商城设置了权限，而用户没有开通则返回提示
        if (!empty($mart_slug) && !$user->isRole($mart_slug)) {
            return $this->jsonResponse([__('mart::message.permission_denied')], '', 422);
        }

        // 验证开通店铺权限
        $data = $request->only([
            'name', 'logo', 'banner', 'return_name', 'return_phone', 'return_address', 'about'
        ]);

        $data['user_id'] = $user->id;
        $data['status'] = config('qihu.mart_default_status', 0);

        if ($result = $this->mart->createMart($data)) {
            return new MartResource($result);
        }

        return $this->jsonResponse([__('mart::message.create_fail')], '', 422);
    }

    /**
     * 店铺详细
     *
     * @param $id
     * @return MartResource
     */
    public function show($id)
    {
        return new MartResource($this->mart->findMartById($id));
    }

    // 更新店铺
    public function update(MartRequest $request, $id)
    {
        if (Auth::id() != $id) {
            return $this->jsonResponse([__('mart::message.permission_denied')], '', 422);
        }

        $data = $request->only([
            'name', 'logo', 'banner', 'return_name', 'return_phone', 'return_address', 'about'
        ]);

        // 如果重新开通店铺，携带status值，则店铺状态设为0，重新提交审核
        if ($request->has('status')) {
            $data['status'] = 0;
        }

        if ($this->mart->where('user_id', $id)->update($data)) {
            return $this->jsonResponse(['id' => intval($id)]);
        }

        return $this->jsonResponse([__('mart::message.update_fail')], '', 422);
    }

    /**
     * 注销店铺
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if (Auth::id() != $id) {
            return $this->jsonResponse([__('mart::message.permission_denied')], '', 422);
        }

        if ($this->mart->cancelMart($id)) {
            return $this->jsonResponse(['id' => intval($id)]);
        }

        return $this->jsonResponse([__('mart::message.cancel_fail')], '', 422);
    }
}