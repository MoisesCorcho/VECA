# Filament Test

-   To debug the error from a form call you can put the result into a variable and do a dd($variable->errors())

```
$response = livewire(CreateSurvey::class)
        ->fillForm($formData)
->call('create');

dd($response->errors());
```
