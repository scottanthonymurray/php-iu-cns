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
   * Normal priority flag.
   *
   * @var string
   */

  const PRIORITY_NORMAL = 'NORMAL';

  /**
   * Urgent priority flag.
   *
   * @var string
   */

  const PRIORITY_URGENT = 'URGENT';

  /**
   * Notification title.
   *
   * @var string
   */

  public $title;

  /**
   * Notification summary.
   *
   * @var string
   */

  public $summary;

  /**
   * Notification SMS description.
   *
   * @var string
   */

  public $sms_description;

  /**
   * Notification priority.
   *
   * @var string
   */

  public $priority;

  /**
   * Notification primary action URL.
   *
   * @var string
   */

  public $primary_action_url;

  /**
   * Notification secondary action URL.
   *
   * @var string
   */

  public $secondary_action_url;

  /**
   * Notification type.
   *
   * @var string
   */

  public $type;

  /**
   * Notification expiration date as Unix timestamp.
   *
   * @var int
   */

  public $expires_at;

  /**
   * Notification reply-to email address.
   *
   * @var string
   */

  public $reply_to;

  /**
   * Notification recipients.
   *
   * @var array
   */

  public $recipients = [];

  /**
   * Constructor.
   *
   * @param string $title       Title
   * @param string $description Description
   * @param string $type        Type as defined in CNS application
   * @param array  $recipients  Recipients
   */

  public function __construct(
    string $title,
    string $description,
    string $type,
    array  $recipients
  ) {
    $this->priority = self::PRIORITY_NORMAL;
    $this->expires_at = strtotime('+30 days');
    $this->title = $title;
    $this->description = $description;
    $this->type = $type;
    $this->recipients = $recipients;
  }

  /**
   * Flags the notification as urgent. Returns the notification to enable a
   * fluent interface.
   *
   * @return void
   */

  public function flagAsUrgent(): void
  {
    $this->priorty = self::PRIORITY_URGENT;
  }

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
      'primaryActionURL' => $this->primary_action_url,
      'secondaryActionURL' => $this->secondary_action_url,
      'notificationType' => $this->type,
      'expirationDate' => $this->expires_at,
      'replyTo' => $this->reply_to,
      'recipients' => $this->recipients
    ]);
  }

}