<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GoogleController extends AbstractController
{
   /**
   *Link to this controller to start the "connect" process
   *@Route("/connect/google", name="connect_google")
  * @param ClientRegistry $clientRegistry
   *@return \Symfony\Component \HttpFoundation\RedirectResponse
   **/
    public function connectAction(ClientRegistry $clientRegistry)
    {
        
        return $clientRegistry
            ->getClient('google') // key used in config/packages/knpu_oauth2_client.yaml
            ->redirect();
    }

   
    
  /**
     * After going to Facebook, you're redirected back here
     * because this is the "redirect_route" you configured
     * in config/packages/knpu_oauth2_client.yaml
     *
     * @Route("/connect/google/check", name="connect_google_check")
     */
    public function connectCheckAction(Request $request, ClientRegistry $clientRegistry)
    {
        // ** if you want to *authenticate* the user, then
        // leave this method blank and create a Guard authenticator
        // (read below)

        /*
        $client = $clientRegistry->getClient('google');

        try {
         
            $user = $client->fetchUser();

            // do something with all this new power!
            // e.g. $name = $user->getFirstName();
            $name = $user->getFirstName();
            $email = $user->getEmail();
            
            var_dump($email); die;
            
            // ...
        } catch (IdentityProviderException $e) {
            // something went wrong!
            // probably you should return the reason to the user
            var_dump($e->getMessage()); die;
        }*/
    }
}