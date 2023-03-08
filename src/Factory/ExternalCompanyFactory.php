<?php

namespace App\Factory;

use App\Entity\ExternalCompany;
use App\Repository\ExternalCompanyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<ExternalCompany>
 *
 * @method        ExternalCompany|Proxy create(array|callable $attributes = [])
 * @method static ExternalCompany|Proxy createOne(array $attributes = [])
 * @method static ExternalCompany|Proxy find(object|array|mixed $criteria)
 * @method static ExternalCompany|Proxy findOrCreate(array $attributes)
 * @method static ExternalCompany|Proxy first(string $sortedField = 'id')
 * @method static ExternalCompany|Proxy last(string $sortedField = 'id')
 * @method static ExternalCompany|Proxy random(array $attributes = [])
 * @method static ExternalCompany|Proxy randomOrCreate(array $attributes = [])
 * @method static ExternalCompanyRepository|RepositoryProxy repository()
 * @method static ExternalCompany[]|Proxy[] all()
 * @method static ExternalCompany[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static ExternalCompany[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static ExternalCompany[]|Proxy[] findBy(array $attributes)
 * @method static ExternalCompany[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static ExternalCompany[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ExternalCompanyFactory extends ModelFactory
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
			'name' => self::faker()->company(),
            'address' => self::faker()->text(60),
			'zipcode' => self::faker()->text(12),
            'city' => self::faker()->postcode(),
			'country' => self::faker()->country(),
            'email' => self::faker()->email(),
			'phone' => self::faker()->phoneNumber(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(ExternalCompany $externalCompany): void {})
        ;
    }

    protected static function getClass(): string
    {
        return ExternalCompany::class;
    }
}
