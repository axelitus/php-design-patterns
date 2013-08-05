<?php
/**
 * Part of the axelitus\patterns package.
 *
 * @package     axelitus\patterns
 * @version     0.1
 * @author      Axel Pardemann (axelitusdev@gmail.com)
 * @license     MIT License
 * @copyright   2013 - Axel Pardemann
 * @link        http://axelitus.mx/projects/php-patterns
 * @source      https://github.com/axelitus/php-patterns
 */

namespace axelitus\patterns;

/**
 * interface Forgeable
 *
 * An interface that defines a Forgeable object.
 *
 * @package axelitus\patterns
 * @since       0.1     introduced interface Forgeable
 * @used-by     Factory
 */
interface Forgeable
{
    //region Static Methods/Function

    /**
     * Forges a new instance of the implementing class.
     *
     * @static
     * @since       0.1     introduced public static function forgeable($params = null)
     * @param mixed $params,...     The parameters to forge the implementing class.
     * @return Forgeable        The newly forged object
     */
    public static function forge($params = null);

    //endregion
}