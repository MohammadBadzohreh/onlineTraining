<?php

namespace Badzohreh\Course\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  const TYPE_FREE = 'free';
  const TYPE_CASH="cash";
  static $TYPES=[self::TYPE_FREE,self::TYPE_CASH];
    const STATUS_COMPELETED="completed";
    const STATUS_NOT_COMPELETED="not-completed";
    const STATUS_LOCKED="locked";
    static $STATUSES=[self::STATUS_COMPELETED,self::STATUS_NOT_COMPELETED,self::STATUS_LOCKED];

}
