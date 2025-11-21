# Laravel USSD Package Overview

This package provides tools for building USSD applications in Laravel 12 using a state-driven architecture.

## Architecture

1. **Machine** orchestrates the flow, resolving states and handling continuity.
2. **States** render menus using the fluent `Menu` builder and determine the next state based on input.
   - The `next()` method must return a **State** class name (string) or null, never an Action class name.
3. **Actions** encapsulate side-effect logic invoked from states.
   - Actions are **called** (invoked) within State's `next()` method to perform business logic.
   - Actions are never returned as navigation targets - always return a State class name after calling an action.
4. **Session Repository** maintains user progress and continuity metadata in cache.
5. **Gateway Adapters** normalize incoming requests from different aggregators.

## Key Concept: State vs Action Navigation

**Important**: When implementing a State's `next()` method:
- ✅ **Return State class names**: `return NextState::class;` or `return 'App\\Ussd\\States\\NextState';`
- ✅ **Call Actions for business logic**: `$action->handle($context, $input);` then return a State based on result
- ❌ **Never return Action class names**: `return ProcessAction::class;` will cause a type error
- ❌ **Never return Action instances**: `return new ProcessAction();` will cause a type error

The flow is: **State → (calls Action) → returns next State class name**

See `README.md` and other docs for detailed guides.
