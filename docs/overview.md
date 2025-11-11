# Laravel USSD Package Overview

This package provides tools for building USSD applications in Laravel 12 using a state-driven architecture.

## Architecture

1. **Machine** orchestrates the flow, resolving states and handling continuity.
2. **States** render menus using the fluent `Menu` builder and determine the next state based on input.
3. **Actions** encapsulate side-effect logic invoked from states.
4. **Session Repository** maintains user progress and continuity metadata in cache.
5. **Gateway Adapters** normalize incoming requests from different aggregators.

See `README.md` and other docs for detailed guides.
