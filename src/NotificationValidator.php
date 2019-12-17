<?php

declare(strict_types=1);

/**
 * This file contains the NotificationValidator class for the IU Central
 * Notification Service client library.
 *
 * @copyright 2020 The Trustees of Indiana University
 * @license   BSD-3-Clause
 */

namespace Edu\Iu\Notifications;

/**
 * The NotificationValidator class validates a notification to be sent via the
 * Central Notification Service.
 *
 * @author Scott Anthony Murray <scanmurr@iu.edu>
 * @since  1.0.0
 */

class NotificationValidator
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

  const MAX_SMS_LENGTH = 400;
  
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
   * Validation errors.
   *
   * @var array
   */

  private $errors = [];

  /**
   * Validates a notification. Returns true if no validation errors were
   * encountered when attempting to validate the notification.
   *
   * @param  Notification $notification Notification to validate
   * @return bool
   */

  public function validate(Notification $notification): bool
  {
    $this->validateFieldLength($notification->title, self::MAX_TITLE_LENGTH);
    $this->validateFieldLength($notification->summary, self::MAX_SUMMARY_LENGTH);
    $this->validateFieldLength($notification->sms_description, self::MAX_SMS_LENGTH);
    $this->validateFieldLength($notification->action_url->primary, self::MAX_URL_LENGTH);
    $this->validateFieldLength($notification->action_url->secondary, self::MAX_URL_LENGTH);
    $this->validateFieldLength($notification->type, self::MAX_TYPE_NAME_LENGTH);
    $this->validateFieldLength($notification->reply_to, self::MAX_EMAIL_LENGTH);
    $this->validateExpirationDate($notification->expires_at, self::MAX_EXPIRATION_DAYS);
    $this->validateRecipients($notification->recipients);

    return ! $this->hasErrors();
  }

  /**
   * Validates a notification's recipients.
   *
   * @param  array $recipients Notification recipients
   * @return void
   */

  private function validateRecipients(array $recipients): void
  {
    if (count($recipients) === 0) {
      $this->logError('No recipients set for notification');
    }
    
    foreach ($recipients as $recipient) {
      $this->validateFieldLength($recipient['username'], self::MAX_USERNAME_LENGTH);
      $this->validateFieldLength($recipient['email'], self::MAX_EMAIL_LENGTH);
    }
  }

  /**
   * Validates that a field value does not exceed the maximum allowed length
   * in characters.
   *
   * @param  string $label Field label
   * @param  string $value Field value to validate
   * @param  int    $max   Maximum length in characters
   * @return void
   */

  private function validateFieldLength(string $value, int $max): void
  {
    if (strlen($value) > $max) {
      $this->logMaxLengthError($value, $max);
    }
  }

  /**
   * Validates that an expiration date does not exceed the maximum allowed
   * number of days into the future.
   *
   * @param  string $label Field label
   * @param  string $date  Date string in YYYY-MM-DD format
   * @param  int    $max   Maximum number of days
   * @return void
   */

  private function validateExpirationDate(string $date, int $max): void
  {
    $max_expiration =  time() + ($max * 24 * 60 * 60);
    $expires_at = strtotime($date);

    if ($expires_at > $max_expiration) {
      $this->logError("$date exceeds max expiration time of $max days");
    }
  }

  /**
   * Logs an error indicating that the given field has exceeded its maximum
   * character length restrictions.
   *
   * @param  string $value Field value
   * @param  int    $max   Maximum character length
   * @return void
   */

  private function logMaxLengthError(string $value, int $max): void
  {
    $this->logError("$value exceeds max length of $max characters");
  }

  /**
   * Logs a validation error.
   *
   * @param  string $message Validation error message
   * @return void
   */

  private function logError(string $message): void
  {
    array_push($this->errors, $message);
  }

  /**
   * Return true if validation errors were logged.
   *
   * @return bool
   */

  public function hasErrors(): bool
  {
    return count($this->errors) > 0;
  }

  /**
   * Returns all logged validation errors.
   *
   * @return array
   */

  public function getErrors(): array
  {
    return $this->errors;
  }

}