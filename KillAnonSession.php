<?php
/**
 * Hooks for KillAnonSession extension
 */
class KillAnonSession {

	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {

		$request = $skin->getUser()->getRequest();

		if (
			!$skin->getUser()->isLoggedIn()
			&&
			$request->getMethod() === 'GET'
			&&
			!$request->response()->getHeader( 'set-cookie' )
		) {
			$session = $request->getSession();

			if ( $session ) {
				$session->unpersist();

				$session->resetAllTokens();

				$session->set( 'wsUserID', 0 ); // Other code expects this
			}
		}
	}

}
