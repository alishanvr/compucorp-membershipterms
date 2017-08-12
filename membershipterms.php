<?php
	
	require_once 'membershipterms.civix.php';
	require_once 'CRM/Membershipterms/DAO/MembershipTerms.php';
	
	/**
	 * Implements hook_civicrm_buildForm().
	 *
	 * Set a default value for an event price set field.
	 *
	 * @param string        $formName
	 * @param CRM_Core_Form $form
	 */
	function membershipterms_civicrm_buildForm( $formName, &$form ) {
		if ( ! in_array( $formName, [
			'CRM_Member_Form_Membership',
			'CRM_Member_Form_MembershipRenewal',
			'CRM_Activity_Form_ActivityLinks'
		] )
		) {
			return;
		}
		
		$templatePath = realpath( dirname( __FILE__ ) . "/templates" );
		CRM_Core_Resources::singleton()
		                  ->addStyleFile( 'com.compucorp.membershipterms', 'css/membershipterms.css' );
		
		if ( $formName != 'CRM_Activity_Form_ActivityLinks' ) {
			CRM_Core_Resources::singleton()
			                  ->addScriptFile( 'com.compucorp.membershipterms', 'js/membershipterms.js' );
			
			$form->add(
				'datepicker',
				'starting_date',
				ts( 'Membership Starting Date' ),
				[ 'class' => '' ],
				true,
				[ 'time' => false, 'date' => 'mm-dd-yy', 'minDate' => '2000-01-01' ]
			);
			
			$form->add(
				'datepicker',
				'ending_date',
				ts( 'Membership Ending Date' ),
				[ 'class' => '' ],
				true,
				[ 'time' => false, 'date' => 'mm-dd-yy', 'minDate' => '2000-01-01' ]
			);
		}
		
		// Fetch Data
		if ( isset( $_GET['cid'] ) && ! empty( $_GET['cid'] ) ) {
			$records = civicrm_api3( 'MembershipTerms', 'get', [
				'contact_id'   => $_GET['cid'],
				'with_deleted' => false, //[False / True]
				'magicword'    => 'magic_MembershipTerms',
				'limit'        => 25,
			] );
			
			$recs = [];
			
			foreach ( $records['values'] as $record ) {
				$recs[] = [
					'contact_id' => $record['contact_id'],
					'start_date' => date( 'j-M-Y', strtotime( $record['start_date'] ) ),
					'end_date'   => date( 'j-M-Y', strtotime( $record['end_date'] ) )
				];
			}
			
			$form->assign( 'records', $recs );
		}
		
		CRM_Core_Region::instance( 'page-body' )->add(
			[
				'template' => "{$templatePath}/membership-terms.tpl"
			]
		);
	}
	
	/**
	 * Implementation of hook_civicrm_entityTypes
	 */
	function membershipterms_civicrm_entityTypes( &$entityTypes ) {
		$entityTypes['CRM_Membershipterms_DAO_MembershipTerms'] = [
			'name'  => 'MembershipTerms',
			'class' => 'CRM_Membershipterms_DAO_MembershipTerms',
			'table' => CRM_Membershipterms_DAO_MembershipTerms::$_tableName
		];
	}
	
	/**
	 * Implements hook_civicrm_postProcess().
	 *
	 * @param string        $formName
	 * @param CRM_Core_Form $form
	 */
	function membershipterms_civicrm_postProcess( $formName, &$form ) {
		
		if ( ! in_array( $formName, [
			'CRM_Member_Form_Membership',
			'CRM_Member_Form_MembershipRenewal'
		] )
		) {
			return;
		}
		
		$params = [
			'contact_id' => $form->getContactID(),
			'start_date' => $form->getElementValue( 'starting_date' ),
			'end_date'   => $form->getElementValue( 'ending_date' ),
			'magicword'  => 'magic_MembershipTerms'
		];
		civicrm_api3( 'MembershipTerms', 'create', $params );
	}
	
	/**
	 * Implements hook_civicrm_config().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
	 */
	function membershipterms_civicrm_config( &$config ) {
		_membershipterms_civix_civicrm_config( $config );
	}
	
	/**
	 * Implements hook_civicrm_xmlMenu().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
	 */
	function membershipterms_civicrm_xmlMenu( &$files ) {
		_membershipterms_civix_civicrm_xmlMenu( $files );
	}
	
	/**
	 * Implements hook_civicrm_install().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
	 */
	function membershipterms_civicrm_install() {
		_membershipterms_civix_civicrm_install();
	}
	
	/**
	 * Implements hook_civicrm_postInstall().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
	 */
	function membershipterms_civicrm_postInstall() {
		_membershipterms_civix_civicrm_postInstall();
	}
	
	/**
	 * Implements hook_civicrm_uninstall().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
	 */
	function membershipterms_civicrm_uninstall() {
		_membershipterms_civix_civicrm_uninstall();
	}
	
	/**
	 * Implements hook_civicrm_enable().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
	 */
	function membershipterms_civicrm_enable() {
		_membershipterms_civix_civicrm_enable();
	}
	
	/**
	 * Implements hook_civicrm_disable().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
	 */
	function membershipterms_civicrm_disable() {
		_membershipterms_civix_civicrm_disable();
	}
	
	/**
	 * Implements hook_civicrm_upgrade().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
	 */
	function membershipterms_civicrm_upgrade( $op, CRM_Queue_Queue $queue = null ) {
		return _membershipterms_civix_civicrm_upgrade( $op, $queue );
	}
	
	/**
	 * Implements hook_civicrm_managed().
	 *
	 * Generate a list of entities to create/deactivate/delete when this module
	 * is installed, disabled, uninstalled.
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
	 */
	function membershipterms_civicrm_managed( &$entities ) {
		_membershipterms_civix_civicrm_managed( $entities );
	}
	
	/**
	 * Implements hook_civicrm_caseTypes().
	 *
	 * Generate a list of case-types.
	 *
	 * Note: This hook only runs in CiviCRM 4.4+.
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
	 */
	function membershipterms_civicrm_caseTypes( &$caseTypes ) {
		_membershipterms_civix_civicrm_caseTypes( $caseTypes );
	}
	
	/**
	 * Implements hook_civicrm_angularModules().
	 *
	 * Generate a list of Angular modules.
	 *
	 * Note: This hook only runs in CiviCRM 4.5+. It may
	 * use features only available in v4.6+.
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
	 */
	function membershipterms_civicrm_angularModules( &$angularModules ) {
		_membershipterms_civix_civicrm_angularModules( $angularModules );
	}
	
	/**
	 * Implements hook_civicrm_alterSettingsFolders().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
	 */
	function membershipterms_civicrm_alterSettingsFolders( &$metaDataFolders = null ) {
		_membershipterms_civix_civicrm_alterSettingsFolders( $metaDataFolders );
	}
	
	// --- Functions below this ship commented out. Uncomment as required. ---
	
	/**
	 * Implements hook_civicrm_preProcess().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
	 *
	 * function membershipterms_civicrm_preProcess($formName, &$form) {
	 *
	 * } // */
	
	/**
	 * Implements hook_civicrm_navigationMenu().
	 *
	 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
	 *
	 * function membershipterms_civicrm_navigationMenu(&$menu) {
	 * _membershipterms_civix_insert_navigation_menu($menu, NULL, array(
	 * 'label' => ts('The Page', array('domain' => 'com.compucorp.membershipterms')),
	 * 'name' => 'the_page',
	 * 'url' => 'civicrm/the-page',
	 * 'permission' => 'access CiviReport,access CiviContribute',
	 * 'operator' => 'OR',
	 * 'separator' => 0,
	 * ));
	 * _membershipterms_civix_navigationMenu($menu);
	 * } // */
