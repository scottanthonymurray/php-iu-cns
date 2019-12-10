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