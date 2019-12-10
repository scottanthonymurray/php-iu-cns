<?php

declare(strict_types=1);

/**
 * This file contains the Notification class for the IU Central Notification
 * Service client library.
 * 
 * @copyright 2020 The Trustees of Indiana University
 * @license   BSD-3-Clause
 */

namespace Edu\Iu\Notifications;

/**
 * The Notification class models a notification to be sent via the Central
 * Notification Service.
 *
 * @author Scott Anthony Murray <scanmurr@iu.edu>
 * @since  1.0.0
 */

class Notification
{

  /**
   * Maximum title length.
   *
   * @var int
   */

  const MAX_TITLE_LENGTH = 50;

  /**
   * Maximum summary length.
   *
   * @var int
   */

  const MAX_SUMMARY_LENGTH = 100;

  /**
   * Maximum SMS description length.
   *
   * @var int
   */

  const MAX_SMS_DESCRIPTION_LENGTH = 400;
  
  /**
   * Maximum call to action URL length.
   *
   * @var int
   */

  const MAX_URL_LENGTH = 2000;

  /**
   * Maximum notification type name length.
   *
   * @var int
   */

  const MAX_TYPE_NAME_LENGTH = 100;

  /**
   * Maximum username length.
   *
   * @var int
   */

  const MAX_USERNAME_LENGTH = 100;

  /**
   * Maximum email length.
   *
   * @var int
   */

  const MAX_EMAIL_LENGTH = 100;

  /**
   * Maximum days before a notification expires.
   *
   * @var int
   */

  const MAX_EXPIRATION_DAYS = 30;

  /**
   * Returns a JSON representation of the notification.
   *
   * @return string
   */

  public function toJson(): string
  {
    return json_encode([
      'title' => $this->title,
      'summary' => $this->summary,
      'smsDescription' => $this->sms_description,
      'priority' => $this->priority,
      'primaryActionURL' => $this->action_url->primary,
      'secondaryActionURL' => $this->action_url->secondary,
      'notificationType' => $this->type,
      'expirationDate' => $this->expires_at,
      'replyTo' => $this->reply_to,
      'recipients' => $this->recipients
    ]);
  }

}