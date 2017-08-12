<?php
	
	require_once 'CRM/Membershipterms/DAO/MembershipTerms.php';
	
	if ( ! class_exists( 'CRM_Membershipterms_BAO_MembershipTerms' ) ) {
		class CRM_Membershipterms_BAO_MembershipTerms extends CRM_Membershipterms_DAO_MembershipTerms {
			
			/**
			 * class constructor
			 */
			function __construct() {
				parent::__construct();
			}
			
			
			/**
			 * Takes an associative array and creates a membership term item
			 *
			 * This function extracts all the params it needs to initialize the created
			 * membership items. The params array could contain additional unused name/value
			 * pairs
			 *
			 * @param array $params (reference ) an assoc array of name/value pairs
			 *
			 * @return object CRM_Membershipterms_BAO_MembershipTerms object
			 * @access public
			 * @static
			 */
			public static function add( &$params ) {
				$item             = new CRM_Membershipterms_DAO_MembershipTerms();
				$item->id         = ( isset( $params['id'] ) && ! empty( $params['id'] ) ) ? $params['id'] : null;
				$item->contact_id = isset( $params['contact_id'] ) ? $params['contact_id'] : false;
				$item->start_date = isset( $params['start_date'] ) ? $params['start_date'] : '';
				$item->end_date   = isset( $params['end_date'] ) ? $params['end_date'] : '';
				$item->created_at = date( 'Y-M-D H:M:s' );
				$item->updated_at = '';
				$item->deleted_at = '';
				
				if ( ! $item->contact_id ) {
					$msg = 'Required Parameter is missing. : Contact ID is required';
					Throw new Exception( $msg, 10001 );
				}
				
				$op = $item->id ? 'edit' : 'create';
				CRM_Utils_Hook::pre( $op, 'MembershipTerms', $item->id, $params );
				$item->save();
				CRM_Utils_Hook::post( $op, 'MembershipTerms', $item->id, $item );
				
				return $item;
			}
			
			
			public static function create( $params ) {
				$params['created_at'] = date( 'Y-m-d h:m:s' );
				$params['updated_at'] = null;
				$params['deleted_at'] = null;
				
				$hook = empty( $params['id'] ) ? 'create' : 'edit';
				CRM_Utils_Hook::pre( $hook, 'MembershipTerms', CRM_Utils_Array::value( 'id', $params ), $params );
				
				$dao = new CRM_Membershipterms_DAO_MembershipTerms();
				$dao->copyValues( $params );
				$dao->save();
				
				CRM_Utils_Hook::post( $hook, 'MembershipTerms', $dao->id, $dao );
				
				return $dao;
			}
			
			
			public static function _retrieve( $params ) {
				$contact_id = ( isset( $params['contact_id'] ) && ! empty( $params['contact_id'] ) ) ? $params['contact_id'] : null;
				
				$where_deleted = isset( $params['with_deleted'] ) ? $params['with_deleted'] : false;
				
				if ( ! $where_deleted ) {
					$where_deleted = 'AND deleted_at IS NULL';
				} else {
					$where_deleted = '';
				}
				
				if ( ! $contact_id ) {
					$msg = 'Required Parameter is missing. : Contact ID is required';
					Throw new Exception( $msg, 10001 );
				}
				
				$sql = "SELECT id, contact_id, start_date, end_date, deleted_at FROM " . parent::$_tableName . " WHERE contact_id = $contact_id  $where_deleted ORDER BY id ASC";
				
				$dao =& CRM_Core_DAO::executeQuery( $sql, [] );
				
				return $dao;
			}
			
			/**
			 * Create a new MembershipTerms based on array-data
			 *
			 * @param array $params key-value pairs
			 *
			 * @return CRM_Membershipterms_DAO_MembershipTerms|NULL
			 *
			 * public static function create($params) {
			 * $className = 'CRM_Membershipterms_DAO_MembershipTerms';
			 * $entityName = 'MembershipTerms';
			 * $hook = empty($params['id']) ? 'create' : 'edit';
			 *
			 * CRM_Utils_Hook::pre($hook, $entityName, CRM_Utils_Array::value('id', $params), $params);
			 * $instance = new $className();
			 * $instance->copyValues($params);
			 * $instance->save();
			 * CRM_Utils_Hook::post($hook, $entityName, $instance->id, $instance);
			 *
			 * return $instance;
			 * } */
			
		}
	}