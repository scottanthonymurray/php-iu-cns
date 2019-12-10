<?php

declare(strict_types=1);

/**
 * This file contains the NotificationService class for the IU Central
 * Notification Service client library.
 *
 * @copyright 2020 The Trustees of Indiana University
 * @license   BSD-3-Clause
 */

namespace Edu\Iu\Notifications;

/**
 * The NotificationService class models the Central Notification Service API.
 *
 * @author Scott Anthony Murray <scanmurr@iu.edu>
 * @since  1.0.0
 */

class NotificationService
{

  /**
   * Authentication token URL.
   *
   * @var string
   */

  const AUTH_TOKEN_URL = 'https://notifications.iu.edu/oauth/token';

  /**
   * Notifications API endpoint URL.
   *
   * @var string
   */

  const API_URL = 'https://notifications.iu.edu/rest-api/secure/notifications';

  /**
   * CNS client ID.
   *
   * @var string
   */

  private $client_id;

  /**
   * CNS client secret.
   *
   * @var string
   */

  private $client_secret;

  /**
   * Temporary authentication token.
   *
   * @var string
   */

  private $auth_token;

  /**
   * Constructor.
   *
   * @param string $client_id     CNS client ID
   * @param string $client_secret CNS client secret
   */

  public function __construct(string $client_id, string $client_secret)
  {
    $this->client_id = $client_id;
    $this->client_secret = $client_secret;
  }

  /**
   * Pushes a notification to the Central Notification Service.
   *
   * @param  Notification $notification Notification to push
   * @return void
   */

  public function pushNotification(Notification $notification): void
  {
    $this->fetchAuthToken();
    $this->postNotificationToService($notification);
  }

  /**
   * Fetches a temporary authentication token with which to make a POST request
   * to the Central Notification Service.
   *
   * @return void
   */

  private function fetchAuthToken(): void
  {

  }

  /**
   * Submits a notification via HTTPS POST to the Central Notification Service
   * REST API endpoint.
   *
   * @param  Notification $notification Notification to push
   * @return void
   */

  private function postNotificationToService(Notification $notification): void
  {

  }

}