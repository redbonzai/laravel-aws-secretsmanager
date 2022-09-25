<?php

namespace Getsolaris\LaravelAwsSecretsManager\Dtos;

use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

/**
 * @see https://docs.aws.amazon.com/aws-sdk-php/v3/api/api-secretsmanager-2017-10-17.html#listsecrets
 */
#[Strict]
class ListSecretsDto extends DataTransferObject
{
    /**
     * @var array|null (Optional) Filters the list of secrets that you
     */
    public ?array $Filters;

    /**
     * @var int|null The maximum number of results to list in the response.
     */
    public ?int $MaxResults = 100;

    /**
     * @var string|null Pagination token that's included if more results are available.
     */
    public ?string $NextToken;

    /**
     * @var string|null The order in which to sort the results. Valid values are Ascending and Descending.
     */
    public ?string $SortOrder;
}
