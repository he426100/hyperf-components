<?php

declare(strict_types=1);
/**
 * This file is part of friendsofhyperf/components.
 *
 * @link     https://github.com/friendsofhyperf/components
 * @document https://github.com/friendsofhyperf/components/blob/3.x/README.md
 * @contact  huangdijia@gmail.com
 */
namespace FriendsOfHyperf\Tinker;

use Hyperf\Utils\Collection;
use Psy\Shell;

class ClassAliasAutoloader
{
    /**
     * All of the discovered classes.
     */
    protected array $classes = [];

    /**
     * Path to the vendor directory.
     */
    protected string $vendorPath;

    /**
     * Explicitly included namespaces/classes.
     */
    protected Collection $includedAliases;

    /**
     * Excluded namespaces/classes.
     */
    protected Collection $excludedAliases;

    /**
     * Create a new alias loader instance.
     */
    public function __construct(protected Shell $shell, string $classMapPath, array $includedAliases = [], array $excludedAliases = [])
    {
        $this->vendorPath = dirname($classMapPath, 2);
        $this->includedAliases = collect($includedAliases);
        $this->excludedAliases = collect($excludedAliases);

        $classes = require $classMapPath;

        foreach ($classes as $class => $path) {
            if (! $this->isAliasable($class, $path)) {
                continue;
            }

            $name = class_basename($class);

            if (! isset($this->classes[$name])) {
                $this->classes[$name] = $class;
            }
        }
    }

    /**
     * Handle the destruction of the instance.
     */
    public function __destruct()
    {
        $this->unregister();
    }

    /**
     * Register a new alias loader instance.
     */
    public static function register(Shell $shell, string $classMapPath, array $includedAliases = [], array $excludedAliases = []): static
    {
        return tap(
            new static($shell, $classMapPath, $includedAliases, $excludedAliases),
            fn ($loader) => spl_autoload_register([$loader, 'aliasClass'])
        );
    }

    /**
     * Find the closest class by name.
     */
    public function aliasClass(string $class)
    {
        if (str_contains($class, '\\')) {
            return;
        }

        $fullName = $this->classes[$class] ?? false;

        if ($fullName) {
            $this->shell->writeStdout("[!] Aliasing '{$class}' to '{$fullName}' for this Tinker session.\n");

            class_alias($fullName, $class);
        }
    }

    /**
     * Unregister the alias loader instance.
     */
    public function unregister()
    {
        spl_autoload_unregister([$this, 'aliasClass']);
    }

    /**
     * Whether a class may be aliased.
     */
    public function isAliasable(string $class, string $path)
    {
        if (! str_contains($class, '\\')) {
            return false;
        }

        if (! $this->includedAliases->filter(fn ($alias) => str_starts_with($class, $alias))->isEmpty()) {
            return true;
        }

        if (str_starts_with($path, $this->vendorPath)) {
            return false;
        }

        if (! $this->excludedAliases->filter(fn ($alias) => str_starts_with($class, $alias))->isEmpty()) {
            return false;
        }

        return true;
    }
}
