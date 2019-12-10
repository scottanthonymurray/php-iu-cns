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
   * Private constructor. Use the Notification::create static method to create
   * a new instance of Notification.
   */

  private function __construct()
  {
    $this->priority = self::PRIORITY_NORMAL;
    $this->expires_at = strtotime('+30 days');
  }

  /**
   * Creates a new notification. Returns the newly created notification to be
   * populated with data via a fluent interface.
   *
   * @return Notification
   */

  public static function create(): Notification
  {
    return new self();
  }

  /**
   * Sets the notification's title. Returns the notification to enable a
   * fluent interface.
   *
   * @param  string $title Notification title
   * @return Notification
   */

  public function setTitle(string $title): Notification
  {
    $max = self::MAX_TITLE_LENGTH;

    if (strlen($title) <= $max) {
      $this->title = $title;

      return $this;
    } else {
      throw new \LengthException(
        "Notification title cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's summary text. Returns the notification to enable
   * a fluent interface.
   *
   * @param  string $summary Notification summary text
   * @return Notification
   */

  public function setSummary(string $summary): Notification
  {
    $max = self::MAX_SUMMARY_LENGTH;

    if (strlen($summary) <= $max) {
      $this->summary = $summary;

      return $this;
    } else {
      throw new \LengthException(
        "Notification summary text cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's SMS description. Returns the notification to
   * enable a fluent interface.
   *
   * @param  string $sms_description Notification SMS description
   * @return Notification
   */

  public function setSmsDescription(string $sms_description): Notification
  {
    $max = self::MAX_SMS_DESCRIPTION_LENGTH;

    if (strlen($sms_description) <= $max) {
      $this->sms_description = $sms_description;

      return $this;
    } else {
      throw new \LengthException(
        "Notification SMS description cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's primary action URL. Returns the notification to
   * enable a fluent interface.
   *
   * @param  string $url Notification primary action URL
   * @return Notification
   */

  public function setPrimaryActionUrl(string $url): Notification
  {
    $max = self::MAX_URL_LENGTH;

    if (strlen($url) <= $max) {
      $this->action_url->primary = $url;

      return $this;
    } else {
      throw new \LengthException(
        "Notification action URL cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's secondary action URL. Returns the notification to
   * enable a fluent interface.
   *
   * @param  string $url Notification secondary action URL
   * @return Notification
   */

  public function setSecondaryActionUrl(string $url): Notification
  {
    $max = self::MAX_URL_LENGTH;

    if (strlen($url) <= $max) {
      $this->action_url->secondary = $url;

      return $this;
    } else {
      throw new \LengthException(
        "Notification action URL cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's type. The type must be registered in the Central
   * Notification Service application. Returns the notification to enable a
   * fluent interface.
   *
   * @param  string $url Notification type
   * @return Notification
   */

  public function setType(string $type): Notification
  {
    $max = self::MAX_TYPE_NAME_LENGTH;

    if (strlen($type) <= $max) {
      $this->type = $type;

      return $this;
    } else {
      throw new \LengthException(
        "Notification type name cannot exceed $max characters"
      );
    }
  }

  /**
   * Sets the notification's reply-to email address. Returns the notification
   * to enable a fluent interface.
   *
   * @param  string $email Notification reply-to email address
   * @return Notification
   */

  public function setReplyToEmail(string $email): Notification
  {
    $max = self::MAX_EMAIL_LENGTH;

    if (strlen($email) <= $max) {
      $this->reply_to = $email;

      return $this;
    } else {
      throw new \LengthException(
        "Notification reply-to email address cannot exceed $max characters"
      );
    }
  }

  /**
   * Adds a recipient to the notification. Returns the notification to enable
   * a fluent interface.
   *
   * @param  string $username Recipient username
   * @param  string $email    Recipient email address
   * @return Notification
   */

  public function addRecipient(string $username, string $email): Notification
  {
    $max_username_length = self::MAX_USERNAME_LENGTH;
    $max_email_length = self::MAX_EMAIL_LENGTH;

    if (strlen($username) > $max_username_length) {
      throw new \LengthException(
        "Recipient username cannot exceed $max_username_length characters"
      );
    }

    if (strlen($email) > $max_email_length) {
      throw new \LengthException(
        "Recipient email address cannot exceed $max_email_length characters"
      );
    }

    $this->recipients[] = [
      'username' => $username,
      'email' => $email
    ];

    return $this;
  }

  /**
   * Sets the notification's expiration date. Returns the notification to
   * enable a fluent interface.
   *
   * @param  string $date Notification expiration date in YYYY-MM-DD format
   * @return Notification
   */

  public function setExpirationDate(string $date): Notification
  {
    $max_days = self::MAX_EXPIRATION_DAYS;
    $max_expiration =  $max_days * 24 * 60 * 60;
    $expires_at = strtotime($date);

    if ($expires_at <= $max_expiration) {
      $this->expires_at = $expires_at;
      return $this;
    } else {
      throw new \InvalidArgumentException(
        "Expiration date must be no more than $max_days days into the future"
      );
    }
  }

  /**
   * Flags the notification as urgent. Returns the notification to enable a
   * fluent interface.
   *
   * @return Notification
   */

  public function flagAsUrgent(): Notification
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
      'primaryActionURL' => $this->action_url->primary,
      'secondaryActionURL' => $this->action_url->secondary,
      'notificationType' => $this->type,
      'expirationDate' => $this->expires_at,
      'replyTo' => $this->reply_to,
      'recipients' => $this->recipients
    ]);
  }

}