<?php

declare(strict_types=1);

namespace Amauri\CanoeAssessment\Infra\Web\Controllers;

use Amauri\CanoeAssessment\Domain\Params\FundCreateParams;
use Amauri\CanoeAssessment\Domain\Params\FundManagerFindParams;
use Amauri\CanoeAssessment\Domain\Params\FundFindParams;
use Amauri\CanoeAssessment\Domain\Params\FundUpdateParams;
use Amauri\CanoeAssessment\Domain\Services\FundManagerService;
use Amauri\CanoeAssessment\Domain\Services\FundService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FundController
{
    public function __construct(
        private FundService $service,
        private FundManagerService $fundManagerService
    ) {}

    public function find(Request $request, Response $response): Response
    {
        $params = new FundFindParams();
        $query = $request->getQueryParams();

        if (array_key_exists('name', $query)) {
            $params->name = $query['name'];
        }

        if (array_key_exists('startYear', $query)) {
            $params->startYear = (int) $query['startYear'];
        }

        if (array_key_exists('manager', $query)) {
            $fundManagerContext = new FundManagerFindParams();
            $fundManagerContext->names = is_array($query['manager']) ? $query['manager'] : [$query['manager']];

            $params->managerIds = array_key_exists('managerIds', $query) ? $query['managerIds'] : [];
            $managers = $this->fundManagerService->find($fundManagerContext);
            foreach ($managers as $manager) {
                $params->managerIds[] = $manager->id;
            }
        }

        $funds = $this->service->find($params);

        $response->getBody()->write(json_encode($funds));

        return $response;
    }

    public function create(Request $request, Response $response): Response
    {
        $params = new FundCreateParams();
        $body = json_decode($request->getBody()->getContents(), true);

        if (array_key_exists('name', $body)) {
            $params->name = $body['name'];
        }

        if (array_key_exists('managerId', $body)) {
            $params->managerId = $body['managerId'];
        }

        if (array_key_exists('aliases', $body)) {
            $params->aliases = $body['aliases'];
        }

        $fund = $this->service->create($params);

        $response->getBody()->write(json_encode($fund));

        return $response;
    }

    public function update(int $id, Request $request, Response $response): Response
    {
        $params = new FundUpdateParams($id);
        $body = json_decode($request->getBody()->getContents(), true);

        if (array_key_exists('name', $body)) {
            $params->name = $body['name'];
        }

        if (array_key_exists('startYear', $body)) {
            $params->startYear = $body['startYear'];
        }

        if (array_key_exists('managerId', $body)) {
            $params->managerId = $body['managerId'];
        }

        if (array_key_exists('aliases', $body)) {
            $params->aliases = $body['aliases'];
        }

        $fund = $this->service->update($params);

        $response->getBody()->write(json_encode($fund));

        return $response;
    }
}