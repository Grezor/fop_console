<?php
/**
 * Copyright (c) Since 2020 Friends of Presta
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License (AFL 3.0)
 * that is bundled with this package in the file docs/licenses/LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/afl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to infos@friendsofpresta.org so we can send you a copy immediately.
 *
 * @author    Friends of Presta <infos@friendsofpresta.org>
 * @copyright since 2020 Friends of Presta
 * @license   https://opensource.org/licenses/AFL-3.0  Academic Free License ("AFL") v. 3.0
 */
namespace FOP\Console\Overriders;

use Symfony\Component\Filesystem\Filesystem;

final class ModuleTemplateOverrider implements OverriderInterface
{
    public function run(string $path): string
    {
        try {
            $final_path = sprintf('themes/%s/%s', $this->getThemePath(), $path);
            $fs = new Filesystem();
            $fs->copy($path, $final_path, true);

            return "File $final_path created";
        } catch (\Exception $exception) {
            return 'An error occurred : ' . $exception->getMessage();
        }
    }

    public function handle(string $path): bool
    {
        return fnmatch('modules/*/*.tpl', $path);
    }

    /**
     * @return string
     */
    private function getThemePath(): string
    {
        // @todo Maybe it's better to rely on the directory property
        return \Context::getContext()->shop->theme->getName();
    }
}
