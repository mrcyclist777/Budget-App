<?php
require 'vendor/autoload.php';

// Uwzględnij zależności Google Cloud za pomocą narzędzia Composer
use Google\Cloud\RecaptchaEnterprise\V1\RecaptchaEnterpriseServiceClient;
use Google\Cloud\RecaptchaEnterprise\V1\Event;
use Google\Cloud\RecaptchaEnterprise\V1\Assessment;
use Google\Cloud\RecaptchaEnterprise\V1\TokenProperties\InvalidReason;

/**
  * Utwórz ocenę, aby przeanalizować ryzyko związane z działaniem w interfejsie użytkownika.
  * @param string $recaptchaKey Klucz reCAPTCHA powiązany z witryną lub aplikacją
  * @param string $token Wygenerowany token uzyskany od klienta.
  * @param string $project Identyfikator Twojego projektu Google Cloud.
  * @param string $action Nazwa działania odpowiadająca tokenowi.
  */
function create_assessment(
  string $recaptchaKey,
  string $token,
  string $project,
  string $action
): void {
  // Utwórz klienta reCAPTCHA.
  // DO ZROBIENIA: zapisz kod klienta w pamięci podręcznej (zalecane) lub wywołaj client.close() przed wyjściem z tej metody.
  $client = new RecaptchaEnterpriseServiceClient();
  $projectName = $client->projectName($project);

  // Ustaw właściwości zdarzenia do śledzenia.
  $event = (new Event())
    ->setSiteKey($recaptchaKey)
    ->setToken($token);

  // Utwórz żądanie oceny.
  $assessment = (new Assessment())
    ->setEvent($event);

  try {
    $response = $client->createAssessment(
      $projectName,
      $assessment
    );

    // Sprawdź, czy token jest prawidłowy.
    if ($response->getTokenProperties()->getValid() == false) {
      printf('The CreateAssessment() call failed because the token was invalid for the following reason: ');
      printf(InvalidReason::name($response->getTokenProperties()->getInvalidReason()));
      return;
    }

    // Sprawdź, czy oczekiwane działanie zostało wykonane.
    if ($response->getTokenProperties()->getAction() == $action) {
      // Uzyskaj ocenę ryzyka i jego przyczyny.
      // Więcej informacji o interpretowaniu testu znajdziesz tutaj:
      // https://cloud.google.com/recaptcha-enterprise/docs/interpret-assessment
      printf('The score for the protection action is:');
      printf($response->getRiskAnalysis()->getScore());
    } else {
      printf('The action attribute in your reCAPTCHA tag does not match the action you are expecting to score');
    }
  } catch (exception $e) {
    printf('CreateAssessment() call failed with the following error: ');
    printf($e);
  }
}

// DO ZROBIENIA: zastąp token i zmienne działania reCAPTCHA przed uruchomieniem przykładu.
create_assessment(
   '6LcJb14qAAAAAPFKeURUoBbmppIq2Q5xjDsETAZa',
   'YOUR_USER_RESPONSE_TOKEN',
   'budget-app-1728650889200',
   'YOUR_RECAPTCHA_ACTION'
);
?>