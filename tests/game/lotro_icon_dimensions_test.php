<?php
/**
 * @package bbGuild LOTRO Extension
 * @copyright (c) 2026 avathar.be
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace avathar\bbguildlotro\tests\game;

use PHPUnit\Framework\TestCase;

/**
 * Guards the icon sets' visual consistency.
 *
 * The roster renders these files at their natural size with no width or
 * height attributes, so a single odd-sized icon misaligns its row. The class icons shipped as a 20/38/43/48 mix and the race icons as a 20/32/48 mix (#3).
 */
class lotro_icon_dimensions_test extends TestCase
{
	public function test_class_images_are_all_48x48(): void
	{
		$this->assertAllSquare('class_images', 48);
	}

	public function test_race_images_are_all_48x48(): void
	{
		$this->assertAllSquare('race_images', 48);
	}


	/**
	 * @return array<string, array{int, int}> filename => [width, height]
	 */
	private function dimensions(string $dir): array
	{
		$path = dirname(__DIR__, 2) . '/images/' . $dir;
		$out  = array();

		foreach (glob($path . '/*.png') as $file)
		{
			$size = getimagesize($file);
			$out[basename($file)] = array($size[0], $size[1]);
		}

		ksort($out);

		return $out;
	}

	private function assertAllSquare(string $dir, int $expected): void
	{
		$wrong = array();

		foreach ($this->dimensions($dir) as $name => $size)
		{
			if ($size !== array($expected, $expected))
			{
				$wrong[$name] = $size[0] . 'x' . $size[1];
			}
		}

		$this->assertSame(
			array(),
			$wrong,
			sprintf('%s icons not %dx%d: %s', $dir, $expected, $expected, json_encode($wrong))
		);
	}
}
