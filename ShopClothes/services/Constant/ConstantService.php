<?php

namespace Services\Constant;
use Core\Responders\ServiceResponse;
use DB;
use File;
use DateTime;
use Auth;

class ConstantService
{
    public function __construct() {

    }

    /**
	 * @todo tạo tin tức mới 
	 * @author Hiển
	 * @since 03/04/2018
	 * @param $data
	 * @return kết quả thực hiện function 
	*/
    public function post($data)
    {
        if($data['constant_alias'] == null)
            $alias = $data['constant_name'];
        else
            $alias = $data['constant_alias'];
        $result = new ServiceResponse();
        try
        {   
            DB::beginTransaction();

            $id = DB::table('tbl_constant')->insertGetId(
                [
                'constant_name'                     =>  $data['constant_name']
                ,'constant_alias'                   =>  str_slug($alias)
                ,'constant_type'                    =>  $data['constant_type']
                ,'constant_head_title'              =>  $data['constant_head_title']
                ,'constant_meta_keyword'            =>  $data['constant_meta_keyword']
                ,'constant_meta_description'        =>  $data['constant_meta_description']
                ,'constant_content'                 =>  $data['constant_content']
                ,'constant_note'                    =>  $data['constant_note']
                ,'constant_creation_time'            =>  time()
                ,'constant_created_by'              =>  Auth::user()->user_id
                ]
                );
                // phát sinh lỗi
            if( !$id ) {
                DB::rollBack();
                                    // add lỗi vào kết quả trả về
                $result->addException(('Đăng tin thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }   
            DB::commit();
            $result->setData( $id );
            return $result;
        } 
        catch (\Exception $ex) {

            DB::rollBack();
                            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

                            // trả về cho controller
            return $result;
        }
    }

/*    public function giveAlias($id,$type)
    {
        $constant = DB::table('tbl_constant')->where('constant_id',$id)->first();
        if($type == "give")
        {
            $alias = $constant->constant_name." ".$constant->constant_head_title." ".$constant->constant_meta_keyword." ".$constant->constant_meta_description." ".$constant->constant_id ;
            $alias = str_slug($alias); 
        }
        elseif($type == "update")
        {
            $alias = $constant->constant_alias." ".$constant->constant_id;
            $alias = str_slug($alias);
        }
        $constant = DB::table('tbl_constant')
        ->where('constant_id',$id)
        ->update(
                ['constant_alias'   => $alias,]
            );
        DB::commit();
        return $alias;
    }*/

    public function update($data,$id)
    {

        if($data['constant_alias'] == null)
            $alias = $data['constant_name'];
        else
            $alias = $data['constant_alias'];
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            $id=DB::table('tbl_constant')
            ->where('constant_id',$id)
            ->update
            (   
                [
                'constant_name'                     =>  $data['constant_name']
                ,'constant_alias'                   =>  str_slug($alias)
                ,'constant_type'                    =>  $data['constant_type']
                ,'constant_head_title'              =>  $data['constant_head_title']
                ,'constant_meta_keyword'            =>  $data['constant_meta_keyword']
                ,'constant_meta_description'        =>  $data['constant_meta_description']
                ,'constant_content'                 =>  $data['constant_content']
                ,'constant_note'                    =>  $data['constant_note']
                ,'constant_last_modified_time'      =>  time()
                ,'constant_last_modified_by'        =>  Auth::user()->user_id
                ]
                );  
            if(!$id) {
                DB::rollBack();
                $result->addException(('Sửa hằng số thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            DB::commit();
            return $result;
        }
        catch (\Exception $ex) {

            DB::rollBack();
                            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);
            return $result;
        }
    }


    public function getList()
    {
        $queryBuilder = DB::table('tbl_constant')
        ->whereNull('constant_deleted_time')
        ->orderBy('constant_name','ASC');
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }
    /**
	 * @todo Lấy danh sách hàng vận chuyển
	 * @author Hiển
	 * @since 03/04/2018
	 * @param 
	 * @return 
	*/
    public function getDetails($id)
    {
        $queryBuilder = DB::table('tbl_constant')
        ->where('constant_id',$id);
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->first();
    }
    public function delete($id)
    {
        $result = new ServiceResponse();
        try
        {
            DB::beginTransaction();
            $id = DB::table('tbl_constant')
            ->where('constant_id',$id)->update(
                [
                'constant_deleted_time'    =>  time()
                ,'constant_deleted_by'      =>  Auth::user()->user_id
                ]
                );

            // phát sinh lỗi
            if( !$id ) {

                DB::rollBack();
                // add lỗi vào kết quả trả về
                $result->addException(('Xóa hằng số thất bại'), 500);
                $result->setStatus(ServiceResponse::STATUS_ERROR);
                $result->setStatusCode(500);
                return $result;
            }
            DB::commit();
            /*$result->setData( $id );*/
            return $result;
        } catch (\Exception $ex) {

            DB::rollBack();
            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }
    public function searchConstant($key,$options)
    {
        try {

            if ($options['paginate']) {
                $options['mode'] = 'QueryBuilder';
                $queryBuilder = $this->getConstantList($key,$options);
                return $queryBuilder->paginate($options['paginate']);
            }
            return $this->getConstantList($key,$area,$options);

        } catch (\Exception $ex) {
            // add lỗi vào kết quả trả về
            dd($ex);
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }

    public function getConstantList($key,$options)
    {
        $queryBuilder = DB::table('tbl_constant')
        ->where('constant_name',"LIKE",'%'.$key."%")
        ->orWhere('constant_type',"LIKE",'%'.$key."%")
        ->orWhere('constant_alias',"LIKE",'%'.$key."%")
        ->orderBy('constant_creation_time','DESC');
        if ($options['mode'] == 'QueryBuilder') {
            return $queryBuilder;
        }
        return $queryBuilder->get();
    }
    public function getIndexConstant()
    {

        $result = new ServiceResponse();
        try{
            // lấy ra danh sách hằng số có mã LIKE "mo-ta"
            $queryBuilder = DB::table('tbl_constant')
            ->whereNull('constant_deleted_time')
            ->orderBy('constant_creation_time','DESC')
            ->get();

            // Đưa các hằng số vào 1 mảng và lấy key là mã hằng số đó
            $constantArr = [];
            foreach( $queryBuilder as $queryItem )
            {

                $constantArr = $constantArr + [ $queryItem->constant_alias => $queryItem ];
            }

            $result->setData( $constantArr );
            return $result;

        } catch (\Exception $ex) {

            // add lỗi vào kết quả trả về
            $result->addException($ex->getMessage(), $ex->getCode());
            $result->setStatus(ServiceResponse::STATUS_ERROR);
            $result->setStatusCode(500);

            // trả về cho controller
            return $result;
        }
    }   
}
