<?php

namespace App\Factory;

use App\Entity\HostCompany;
use App\Repository\HostCompanyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<HostCompany>
 *
 * @method        HostCompany|Proxy create(array|callable $attributes = [])
 * @method static HostCompany|Proxy createOne(array $attributes = [])
 * @method static HostCompany|Proxy find(object|array|mixed $criteria)
 * @method static HostCompany|Proxy findOrCreate(array $attributes)
 * @method static HostCompany|Proxy first(string $sortedField = 'id')
 * @method static HostCompany|Proxy last(string $sortedField = 'id')
 * @method static HostCompany|Proxy random(array $attributes = [])
 * @method static HostCompany|Proxy randomOrCreate(array $attributes = [])
 * @method static HostCompanyRepository|RepositoryProxy repository()
 * @method static HostCompany[]|Proxy[] all()
 * @method static HostCompany[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static HostCompany[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static HostCompany[]|Proxy[] findBy(array $attributes)
 * @method static HostCompany[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static HostCompany[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class HostCompanyFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'email' => self::faker()->email(),
            'name' => self::faker()->company(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(HostCompany $hostCompany): void {})
        ;
    }

    protected static function getClass(): string
    {
        return HostCompany::class;
    }
}
