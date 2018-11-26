<?php
 namespace Core\Models\Doctrine;
 use Doctrine\ORM\EntityRepository;
 //use Doctrine\Common\Util\Inflector;
 use Core\Contracts\Repository;
 
 abstract class BaseRepository extends EntityRepository implements Repository {
	use \LaravelDoctrine\ORM\Pagination\PaginatesFromRequest;

	public function paginateAllPublishedScientists($queryBuilder, $perPage = 60, $pageName = 'page')
    {
        return $this->paginate($queryBuilder->getQuery(), $perPage, $pageName);
	}
	
 	/**
 	 * @todo: Hàm khởi tạo dữ entities
 	 * @param  array $data
 	 * @return Entities
 	 */
	public function create(array $data)
	{
		$entityClass = $this->getClassName();

		$entityE = new $entityClass();
		$entityE->fromArray( $data );

// 		if( method_exists( $entityE, "wishlist" ) ) {

// 			$setPrefix = 'set';
// 			$wishlist = $entityE->wishlist();

// 			foreach( $wishlist as $field ) {

// 				//if ( isset( $data[$field] ) ){

// 					// tên hàm set
// 					$setter = $setPrefix . Inflector::classify( $field );

// 					if( method_exists( $entityE, "wishlist" ) ) {

// 						$entityE->$setter( $data[ $field ] );
// 					}
// 				//}
// 			}
// 		}

		$this->getEntityManager()->persist( $entityE );
		//$this->getEntityManager()->flush( $entityE );

		return $entityE;
	}

	/**
	 * @todo: Hàm update dữ liệu
	 * @param  array $data
	 * @param  $id
	 * @return $entities
	 */
	public function update(array $data, $id)
	{
		$entityE = $this->find($id);
		$entityE->fromArray( $data );

// 		if( method_exists( $entityE, "wishlist" ) ) {

// 			$setPrefix = 'set';
// 			$wishlist = $entityE->wishlist();

// 			foreach( $wishlist as $field ) {

// 				//if ( isset( $data[$field] ) ){

// 					// tên hàm set
// 					$setter = $setPrefix . Inflector::classify( $field );

// 					if( method_exists( $entityE, "wishlist" ) ) {

// 						$entityE->$setter( $data[ $field ] );
// 					}
// 				//}
// 			}
// 		}

		$this->getEntityManager()->persist( $entityE );
		$this->getEntityManager()->flush( $entityE );

		return $entityE;
	}

	/**
	 * @todo hàm xoá 1 entities
	 * @param  $entityE
	 */
	public function delete($entityE)
	{
		$this->getEntityManager()->remove($entityE);
		$this->getEntityManager()->flush($entityE);
		return true;
	}

	/**
	 * @todo Hàm insert $entity xuống DB
	 * @param $entityE
	 */
	public function insert($entityE) {

		$this->getEntityManager()->persist($entityE);
		$this->getEntityManager()->flush($entityE);
		return true;
	}

	/**
     * @todo Hàm xử lý kiểu trả về của QueryBuilder
     * @author croco
     * @since 1-4-2016
     * @param \Doctrine\ORM\QueryBuilder $queryBuilder
     * @param string $mode
     * @throws \Exception
     */
	protected function getDataResults($queryBuilder, $mode = "Entities", $cacheConfig = true) {
		
		// nếu queryBuilder không chính xác
		if( ! ($queryBuilder instanceof \Doctrine\ORM\QueryBuilder)){

			throw new \Exception("queryBuilder Not Found!");
		}

		// nếu kiểu fetch là rỗng thì mặc định lấy kiểu object
		$mode = $mode ? $mode :  "Entities";
		

		/**
		 * @todo Cấu hình cache
		*/
		// if( !$this->getEntityManager()->getCacheConfigs() ) {

		// 	$cacheConfig = false;
		// }

		if( true === $cacheConfig ) {

			$cacheConfig = array(
				'name'	=>	$this->_entityName
			);
		} else if( $cacheConfig && !is_array($cacheConfig) ) {

			$cacheConfig = array(
				'name'	=>	$cacheConfig
			);
		}

		if( $cacheConfig ) {

			$cacheConfig = array_merge(config('doctrine.cache.query') , $cacheConfig);
		}

		if( $mode != "QueryBuilder" ) {

			$query = $queryBuilder->getQuery();

			if( $cacheConfig ) {


				$query = $query->useResultCache(
					true, 
					$cacheConfig['lifetime'], 
					$cacheConfig['name']
				);
				$query->setCacheable(true);
				$query->setLifetime($cacheConfig['lifetime']);
				//$query->setCacheRegion($cacheConfig['name']);
				//$query->setCacheMode("READ_WRITE");
			}
		} else if( $cacheConfig ) {

			$queryBuilder->setCacheable(true);
			$queryBuilder->setLifetime($cacheConfig['lifetime']);
		}

		/**
		 * @end Cấu hình cache
		*/
		
		switch ($mode){

			case 'QueryBuilder':
				$result = $queryBuilder;
				break;

			case 'DQL':
				$result = $query->getDQL();
				break;

			case 'SQL':
				$result = $query->getSQL();
				break;

			case 'Array':

				$result = $query->getArrayResult();
				break;

			case 'OneOrNullEntity':
			case 'OneOrNullEntities':
			case 'OneOrNull':

				//$result = $query->getOneOrNullResult();

				$result = $query->getResult();
				if( $result && is_array( $result ) ) {

					return $result[0];
				}
				return null;
				break;

			case 'Entity':
			case 'Entities':
			default:

				$result = $query->getResult();
				break;
		}
			// trả về
		return $result;
	}

	/**
	 * @todo Hàm lấy danh sách field trong db
	 * @param alias: prefix
	 * @param fields: danh sách field cần lấy
	 * @param className: tên class của entities cần lấy
	 * @return array field
	*/
	protected function getFields( $alias, $fields = array(), $className = null ) {
		
		// entities class
		if( !$className ) {
			$className = $this->_entityName;
		}

		$meta = $this->getEntityManager()->getClassMetadata( $className );
		$selectColumns = array();

		if( count($fields) ) {

			array_map(function($colName) use ($alias, &$selectColumns, $meta) {
				
				if( in_array($colName, $meta->columnNames) ) {

					$selectColumns[] = $alias . "." .$colName;
				}
			}, $fields);
		} else {

			array_map(function($colName) use ($alias, &$selectColumns) {
		
				$selectColumns[] = $alias . "." .$colName;
			}, $meta->columnNames);	
		}

		return $selectColumns;
	}


	/**
	 * @todo Hàm tạo mã tin
	 * @author Croco
	 * @since 12-4-2017
	 * @param $accountE account entities
	 * @return string
	*/
	public function getCode( $accountE, $returnCount = true ) {
		
		$prefix = str_replace(
			"tbl_",
			"",
			$this->getEntityManager()
				->getClassMetadata($this->_entityName)->table['name']) . "_";

		$createdByField = camel_case($prefix . "created_by");

		$queryBuilder = $this->getEntityManager()
			->createQueryBuilder()
			->select(array(
				"GC." . $prefix . "id",
				"GC." . $prefix . "order"
			))
			->from($this->_entityName, 'GC')
			->andWhere("GC." . $createdByField . " = :id")
			//->andWhere("GC.productRiversCreatedBy = :id")
			->setParameter('id', $accountE)
			->andWhere("GC." . $prefix . "order is not null")
			->orderBy("GC." . $prefix . "order", 'DESC')
			->setMaxResults(1);
		$query = $queryBuilder->getQuery()->getOneOrNullResult();

		$count = ($query[$prefix . "order"] + 1) % 1000 != 0 ? 
					$query[$prefix . "order"] + 1 :
					$query[$prefix . "order"] + 2;

		if($returnCount) return $count;
		
		$count = str_pad($count, 3, "0", STR_PAD_LEFT);
		return $accountE->getAccountCode() . "-" . substr($count, -3);
	}
 }