# 0. Coding Style and Purpose

## Coding Style

Based on API-first + Domain-Driven Design (DDD) + Test-Driven Development (TDD).

## Purpose

Build a Laravel application using DDD with the premise of integrating with a Next.js (frontend) application, aiming for independence of business logic, unified error handling, and thorough test-driven development.

## Key Points

1. Independence of business logic (DDD)
2. Unified error handling (exception-based)
3. Thorough TDD
4. Type-safe DTOs and Value Objects
5. Consistency with API documentation (e.g., OpenAPI)
6. SOLID principles
7. Proper layer separation (Onion Architecture)

# 1. Principles

## 1.1. API-First

- Design the backend API first, assuming integration with Next.js.
- Follow RESTful or OpenAPI guidelines, standardizing authentication, error handling, and response format.
- Manage the Laravel endpoints using OpenAPI to maintain alignment with the Next.js side.

## 1.2. DDD (Domain-Driven Design) Adoption

Employ Onion Architecture by separating into four layers:

1. **Domain Layer**

- The core of business logic
- Consists of Entities, ValueObjects, DomainServices, DomainEvents, and Aggregate Roots

2. **Application Layer**

- Executes Domain layer functionalities in terms of use cases
- Includes UseCases, DTOs, and QueryServices

3. **Infrastructure Layer**

- Handles persistence and external services (Eloquent, DynamoDB, Redis, S3, external APIs)
- Contains Repositories, CacheService, and ExternalApiClient

4. **Presentation Layer**

- Manages API request validation, authentication, and response formatting
- Contains Controllers, FormRequests for validation, and JsonResources for response formatting

## 1.3. Exception-Based Error Handling

- Primarily use DomainException, ApplicationException, InfrastructureException.
- Design a unified error response (e.g., JSON containing status, message, and code):

## 1.4. TDD (Test-Driven Development)

Strictly follow the Red-Green-Refactor cycle:

1. Red → Write failing tests first
2. Green → Implement the minimal code to pass the tests
3. Refactor → Improve design and refactor, ensuring tests pass again

Hierarchy of tests:

- Unit Tests (Domain Layer)
- Use Case Tests (Application Layer)
- API Tests (Presentation Layer, Feature Tests)
- Integration Tests (including end-to-end with Infrastructure)

# 2. Implementation Workflow

1. Define the Ubiquitous Language (unify terminology within the team).
2. Design the domain (identify Entities, ValueObjects, and AggregateRoots).
3. Design repository interfaces (how domain models are persisted and retrieved).
4. Design use cases (UseCase), together with DTOs.
5. Write tests for use cases (TDD).
6. Implement repositories (Eloquent, DynamoDB, etc.) in the infrastructure.
7. Implement the presentation layer (Controllers, FormRequests, JsonResources).
8. Create or update API documentation (OpenAPI/Swagger).
9. Conduct integration tests and refactoring (verify end-to-end, including the database).

# 3. Directory Structure

```plaintext
app/
│── Domain/         # Domain Layer (business logic)
│   ├── Entities/
│   ├── ValueObjects/
│   ├── Services/
│   ├── Events/
│── Application/    # Application Layer (use cases)
│   ├── UseCases/
│   ├── DTOs/
│   ├── Queries/
│── Infrastructure/ # Infrastructure Layer (persistence, external services)
│   ├── Repositories/
│   ├── ExternalApis/
│   ├── Cache/
│── Http/          # Presentation Layer (API)
│   ├── Controllers/
│   ├── Requests/
│   ├── Resources/
│── Exceptions/    # Custom exceptions
│── Providers/     # Service providers
tests/
│── Unit/          # Unit tests (Domain Layer)
│── Feature/       # Feature tests (Application Layer)
│── Integration/   # Integration tests (E2E)
```

# 4. Best Practices for API Design

- Resource-based endpoint naming (e.g., /articles, /users).
- Unified error response format (linked to exception classes).
- Consider compliance with OpenAPI or JSON:API.
- Always design DTOs for both requests and responses.
- Introduce caching or rate-limiting as needed for performance.

# 5. TDD-Based Test Design

**Domain Layer (Unit Tests)**

- Verify business logic of ValueObjects, Entities, and DomainServices.

**Use Cases (Application Layer)**
- Mock repositories, covering all branching scenarios in the use cases.

**API Tests (Presentation Layer)**
- Simulate requests and validate HTTP responses.

**Integration Tests (E2E)**
- Include DB and external service verification.
- Rigorously adhere to the Red-Green-Refactor cycle.

# 6. CI/CD and Deployment

- Use GitHub Actions or similar to build a CI/CD pipeline.
- Block deployments if tests fail.
- Manage .env files by environment (development, staging, production).
- Optimize performance in production using Redis or a CDN.
- Monitor and log errors with tools like Sentry or Datadog.

# 7. Operations and Maintenance

- Plan for API versioning (e.g., /api/v1/, /api/v2/).
- Optimize performance (DB tuning, caching strategies, etc.).
- Conduct regular code reviews and refactoring to ensure compliance with SOLID and DDD.

# 8. Development Flow (Detailed Workflow)

## 1. Step 0: Concept Design (once per project or domain)

- Centrally manage Ubiquitous Language for the entire application or domain.
- Decide on use cases, ID design policies, and deletion strategies (logical vs. physical) from a broad perspective.

## 2. Step 1: Domain Modeling (each time you add a new use case)

- Extend the Ubiquitous Language definitions.
- Create or update Entities, ValueObjects, DomainServices, and DomainExceptions.
- Enforce immutability in ValueObjects—fixing internal state via constructors or factories.

## 3. Step 2: Implement Application Layer

- Create DTOs (the bridge between API requests/responses and the domain).
- Define UseCase classes (single responsibility).
- Use Mappers or Assemblers for DTO ↔ Entity transformation.

## 4. Step 3: Test First

- Write tests for use cases (both normal and exceptional paths).
- Write unit tests for domain logic (ValueObjects, AggregateRoots, etc.).

## 5. Step 4: Implement Infrastructure Layer

- Implement Repository interfaces (Eloquent, DynamoDB, etc.).
- Provide wrappers for SDK clients and design interfaces for easy mocking.

## 6. Step 5: Implement Presentation Layer

- Controllers: FormRequests (validation) + UseCase invocation + JsonResources (response formatting).
- Explicitly validate and transform inputs/outputs to express them as an API.

## 7. Step 6: API Testing and E2E Verification

- Use Feature Tests to verify the API flow (including authentication/authorization).
- Test DB and external service connections.
- Cover edge cases such as null parameters or unexpected errors.

## 8. Step 7: Deployment, Operation, Documentation

- Run migrations and seeding.
- Set up API versioning and error monitoring (Sentry, CloudWatch, etc.).
- Document outcomes in Notion, Qiita, Zenn, or similar.

## 9. Step 8: Continual Improvement of Design Templates

- Standardize UseCase, Repository, and DTO+Mapper templates.
- Maintain documentation on Domain Layer design conventions.
- Share style guides within the team or with the open-source community.

## Other

- Output in Japanese

- Data Transfer Objects (DTOs) are used to transfer data between layers.
    | **From → To**               | **Recommended Data Structure** | **Notes**                                                                                                    |
    | --------------------------- | ------------------------------ | ------------------------------------------------------------------------------------------------------------ |
    | Controller → UseCase        | DTO                            | To explicitly separate the responsibility of request formatting                                              |
    | UseCase → Controller        | DTO or Entity                  | If you use a JsonResource for formatting, you can directly pass the Entity. Choose based on API requirements |
    | UseCase → Domain            | Entity / VO                    | Use domain models to apply business logic                                                                    |
    | UseCase → Repository        | Entity                         | Pass Entities to ensure consistency within the aggregate                                                     |
    | Repository → UseCase        | Entity                         | Convert persisted data back into an Entity and return it                                                     |
    | Repository ⇄ Infrastructure | DTO / Array                    | The Infrastructure layer handles data transformation (Mapper)                                                |
    | JsonResource ⇐ Controller   | Entity or DTO                  | Choose according to frontend requirements. If passing an Entity is sufficient, it can go directly            |
