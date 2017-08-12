<?php
	
	/*
	+--------------------------------------------------------------------+
	| CiviCRM version 4.6                                                |
	+--------------------------------------------------------------------+
	| Copyright CiviCRM LLC (c) 2004-2015                                |
	+--------------------------------------------------------------------+
	| This file is a part of CiviCRM.                                    |
	|                                                                    |
	| CiviCRM is free software; you can copy, modify, and distribute it  |
	| under the terms of the GNU Affero General Public License           |
	| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
	|                                                                    |
	| CiviCRM is distributed in the hope that it will be useful, but     |
	| WITHOUT ANY WARRANTY; without even the implied warranty of         |
	| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
	| See the GNU Affero General Public License for more details.        |
	|                                                                    |
	| You should have received a copy of the GNU Affero General Public   |
	| License and the CiviCRM Licensing Exception along                  |
	| with this program; if not, contact CiviCRM LLC                     |
	| at info[AT]civicrm[DOT]org. If you have questions about the        |
	| GNU Affero General Public License or the licensing of CiviCRM,     |
	| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
	+--------------------------------------------------------------------+
	*/
	
	require_once 'CRM/Core/DAO.php';
	require_once 'CRM/Utils/Type.php';
	
	if ( ! class_exists( 'CRM_Membershipterms_DAO_MembershipTerms' ) ) {
		class CRM_Membershipterms_DAO_MembershipTerms extends CRM_Core_DAO {
			/**
			 * static instance to hold the table name
			 *
			 * @var string
			 * @static
			 */
			public static $_tableName = 'civicrm_membershipterms';
			/**
			 * static instance to hold the field values
			 *
			 * @var array
			 * @static
			 */
			public static $_fields = null;
			
			/**
			 * static instance to hold the field keys
			 *
			 * @var array
			 * @static
			 */
			public static $_fieldKeys = null;
			/**
			 * static instance to hold the FK relationships
			 *
			 * @var string
			 * @static
			 */
			public static $_links = null;
			/**
			 * static instance to hold the values that can
			 * be imported
			 *
			 * @var array
			 * @static
			 */
			public static $_import = null;
			/**
			 * static instance to hold the values that can
			 * be exported
			 *
			 * @var array
			 * @static
			 */
			public static $_export = null;
			/**
			 * static value to see if we should log any modifications to
			 * this table in the civicrm_log table
			 *
			 * @var boolean
			 * @static
			 */
			public static $_log = false;
			/**
			 * membership term ID - UQ
			 *
			 * @var int unsigned
			 */
			public $id;
			/**
			 * contact id - FK
			 *
			 * @var int unsigned
			 */
			public $contact_id;
			/**
			 * when the period / term is starts
			 *
			 * @var DATETIME
			 */
			public $start_date;
			/**
			 * when the period / term is ends.
			 *
			 * @var DATETIME
			 */
			public $end_date;
			/**
			 * when the record is updated last time
			 *
			 * @var DATETIME
			 */
			public $updated_at;
			/**
			 * when the record is created.
			 *
			 * @var DATETIME
			 */
			public $created_at;
			/**
			 * when the record is deleted. Use for soft deletes
			 *
			 * @var DATETIME
			 */
			public $deleted_at;
			
			/**
			 * class constructor
			 *
			 * @access public
			 */
			function __construct() {
				$this->__table = self::$_tableName;
				
				parent::__construct();
			}
			
			/**
			 * return foreign links
			 *
			 * @access public
			 * @return array
			 */
			function &links() {
				if ( ! ( self::$_links ) ) {
					self::$_links = [
						'contact_id' => 'civicrm_contact:id'
					];
				}
				
				return self::$_links;
			}
			
			/**
			 * returns all the column names of this table
			 *
			 * @access public
			 * @return array
			 */
			static function &fields() {
				if ( ! ( self::$_fields ) ) {
					self::$_fields = [
						'id'         => [
							'name'     => 'id',
							'type'     => CRM_Utils_Type::T_INT,
							'required' => true
						],
						'contact_id' => [
							'name'     => 'contact_id',
							'type'     => CRM_Utils_Type::T_INT,
							'required' => true
						],
						'start_date' => [
							'name'     => 'start_date',
							'type'     => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
							'required' => true
						],
						'end_date'   => [
							'name'     => 'end_date',
							'type'     => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
							'required' => true
						],
						'updated_at' => [
							'name'     => 'updated_at',
							'required' => true,
							'type'     => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME
						],
						'created_at' => [
							'name'     => 'created_at',
							'required' => true,
							'type'     => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME
						],
						'deleted_at' => [
							'name'     => 'deleted_at',
							'required' => true,
							'type'     => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME
						]
					];
				}
				
				return self::$_fields;
			}
			
			/**
			 * returns the names of this table
			 *
			 * @access public
			 * @return string
			 */
			static function getTableName() {
				return CRM_Core_DAO::getLocaleTableName( self::$_tableName );
			}
			
			/**
			 * returns if this table needs to be logged
			 *
			 * @access public
			 * @return boolean
			 */
			function getLog() {
				return self::$_log;
			}
			
			/**
			 * returns the list of fields that can be imported
			 *
			 * @access public
			 * return array
			 */
			function &import( $prefix = false ) {
				if ( ! ( self::$_import ) ) {
					self::$_import = [];
					$fields        = self::fields();
					foreach ( $fields as $name => $field ) {
						if ( CRM_Utils_Array::value( 'import', $field ) ) {
							if ( $prefix ) {
								self::$_import['membership_terms'] = &$fields[ $name ];
							} else {
								self::$_import[ $name ] = &$fields[ $name ];
							}
						}
					}
				}
				
				return self::$_import;
			}
			
			/**
			 * Returns an array containing, for each field, the arary key used for that
			 * field in self::$_fields.
			 *
			 * @return array
			 */
			static function &fieldKeys() {
				if ( ! ( self::$_fieldKeys ) ) {
					self::$_fieldKeys = [
						'id'         => 'id',
						'contact_id' => 'contact_id',
						'start_date' => 'start_date',
						'end_date'   => 'end_date',
						'created_at' => 'created_at',
						'updated_at' => 'updated_at',
						'deleted_at' => 'deleted_at',
					];
				}
				
				return self::$_fieldKeys;
			}
			
			/**
			 * returns the list of fields that can be exported
			 *
			 * @access public
			 * return array
			 */
			function &export( $prefix = false ) {
				if ( ! ( self::$_export ) ) {
					self::$_export = [];
					$fields        = self::fields();
					foreach ( $fields as $name => $field ) {
						if ( CRM_Utils_Array::value( 'export', $field ) ) {
							if ( $prefix ) {
								self::$_export['membership_terms'] = &$fields[ $name ];
							} else {
								self::$_export[ $name ] = &$fields[ $name ];
							}
						}
					}
				}
				
				return self::$_export;
			}
		}
	}
