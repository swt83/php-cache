<?php

namespace Travis;

class Cache {

	/**
	 * Set data.
	 *
	 * @param	string	$name
	 * @param	int		$minutes
	 * @param	mixed	$value
	 * @return	void
	 */
	public static function set($name, $minutes, $value)
	{
		// path
		$path = static::path($name);

		// package
		$package = array(
			'time' => time(),
			'expires' => $minutes ? strtotime('+'.$minutes.' minutes') : false,
			'payload' => is_object($value) && ($value instanceof \Closure) ? $value() : $value,
		);

		// encode
		$package = json_encode($package);

		// save
		file_put_contents($path, $package);
	}

	/**
	 * Get data.
	 *
	 * @param	string	$name
	 * @return	mixed
	 */
	public static function get($name, $coords = null)
	{
		// path
		$path = static::path($name);

		// load
		$package = file_get_contents($path);

		// decode
		$package = json_decode($package);

		// check expiry...
		if ($package->expires and time() > $package->expires)
		{
			// return null
			return null;
		}

		// return
		return $coords ? ex($package->payload, $coords, null) : $package->payload;
	}

	/**
	 * Forget data.
	 *
	 * @param	string	$name
	 * @return	void
	 */
	public static function forget($name)
	{
		// path
		$path = static::path($name);

		// delete
		unlink($path);
	}

	/**
	 * Forget all data.
	 *
	 * @return	void
	 */
	public static function clear()
	{
		// files
		$files = scandir(static::dir());

		// foreach...
		foreach ($files as $file)
		{
			if ($file != '.' and $file != '..' and $file != '.gitkeep')
			{
				// path
				$path = static::dir().$file;

				// delete
				unlink($path);
			}
		}
	}

	/**
	 * Return a directory.
	 *
	 * @return	string
	 */
	protected static function dir()
	{
		return __DIR__.'/../../storage/';
	}

	/**
	 * Return a path.
	 *
	 * @param	string	$name
	 * @return	string
	 */
	protected static function path($name)
	{
		return static::dir().md5($name).'.cache';
	}

}