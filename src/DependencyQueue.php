<?php

namespace Croct\WordPress;

final class DependencyQueue
{
    /**
     * @param array<Dependency> $dependencies
     *
     * @return void
     */
    public function enqueue(array $dependencies)
    {
        $others = [];
        foreach ($dependencies as $dependency) {
            if ($dependency instanceof ExternalDependency) {
                $this->enqueueDependency($dependency);

                continue;
            }

            $others[] = $dependency;
        }

        foreach ($others as $dependency) {
            $this->enqueueDependency($dependency);
        }
    }

    /**
     * @return void
     */
    private function enqueueDependency(Dependency $dependency)
    {
        if ($dependency instanceof InlineDependency) {
            $this->enqueueInlineDependency($dependency);

            return;
        }

        if ($dependency instanceof ExternalDependency) {
            $this->enqueueExternalDependency($dependency);

            return;
        }

        throw new \LogicException(\sprintf('Unsupported dependency type "%s".', \get_class($dependency)));
    }

    /**
     * @return void
     */
    private function enqueueExternalDependency(ExternalDependency $dependency)
    {
        $type = $dependency->getType();

        switch ($type) {
            case Dependency::TYPE_SCRIPT:
                \wp_enqueue_script(
                    $dependency->getHandle(),
                    $dependency->getSourceUri(),
                    $dependency->getDependencies(),
                    self::resolveVersion($dependency->getVersion())
                );
                break;

            case Dependency::TYPE_STYLE:
                \wp_enqueue_style(
                    $dependency->getHandle(),
                    $dependency->getSourceUri(),
                    $dependency->getDependencies(),
                    self::resolveVersion($dependency->getVersion())
                );
                break;

            default:
                throw new \LogicException(\sprintf('Unsupported external dependency type "%s".', $type));
        }
    }

    /**
     * @return void
     */
    private function enqueueInlineDependency(InlineDependency $dependency)
    {
        $type = $dependency->getType();

        switch ($type) {
            case Dependency::TYPE_SCRIPT:
                \wp_add_inline_script(
                    $dependency->getHandle(),
                    $dependency->getSource(),
                    $dependency->getPlacementPosition()
                );
                break;

            case Dependency::TYPE_STYLE:
                \wp_add_inline_style($dependency->getHandle(), $dependency->getSource());
                break;

            default:
                throw new \LogicException(\sprintf('Unsupported inline dependency type "%s".', $type));
        }
    }

    /**
     * @param mixed $version
     *
     * @return mixed
     */
    private static function resolveVersion($version)
    {
        if ($version === ExternalDependency::VERSION_NONE) {
            return null;
        }

        if ($version === ExternalDependency::VERSION_WORDPRESS) {
            return false;
        }

        return $version;
    }
}
