<?php
	
	/**
	 * MembershipTerms.Get API specification (optional)
	 * This is used for documentation and validation.
	 *
	 * @param array $spec description of fields supported by this API call
	 *
	 * @return void
	 * @see http://wiki.civicrm.org/confluence/display/CRMDOC/API+Architecture+Standards
	 */
	function _civicrm_api3_membership_terms_Get_spec( &$spec ) {
		$spec['magicword']['api.required']  = 1;
		$spec['contact_id']['api.required'] = 1;
	}
	
	/**
	 * MembershipTerms.Get API
	 *
	 * @param array $params
	 *
	 * @return array API result descriptor
	 * @see civicrm_api3_create_success
	 * @see civicrm_api3_create_error
	 * @throws API_Exception
	 */
	function civicrm_api3_membership_terms_Get( $params ) {
		if ( array_key_exists( 'magicword', $params ) && $params['magicword'] == 'magic_MembershipTerms' ) {
			
			$dao    = CRM_Membershipterms_BAO_MembershipTerms::_retrieve( $params );
			$result = $dao->fetchAll();
			
			// ALTERNATIVE: $returnValues = array(); // OK, success
			// ALTERNATIVE: $returnValues = array("Some value"); // OK, return a single value
			
			// Spec: civicrm_api3_create_success($values = 1, $params = array(), $entity = NULL, $action = NULL)
			return civicrm_api3_create_success( $result, $params, 'MembershipTerms', 'get' );
		} else {
			throw new API_Exception(/*errorMessage*/
				'Sorry! wrong magicword is provided.', /*errorCode*/
				10002 );
		}
	}
