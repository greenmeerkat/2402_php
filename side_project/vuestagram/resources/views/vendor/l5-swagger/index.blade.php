<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{config('l5-swagger.documentations.'.$documentation.'.api.title')}}</title>
    <link rel="stylesheet" type="text/css" href="{{ l5_swagger_asset($documentation, 'swagger-ui.css') }}">
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-32x32.png') }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ l5_swagger_asset($documentation, 'favicon-16x16.png') }}" sizes="16x16"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <style>
    html
    {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
    }
    *,
    *:before,
    *:after
    {
        box-sizing: inherit;
    }

    body {
      margin:0;
      background: #fafafa;
    }
    td:nth-child(1) {
        width: 50px; !important
    }
    td:nth-child(2) {
        width: 50px;
    }
    td:nth-child(3) {
        width: 300px;
    }
    [class="property-row"] > td > span {
        min-width: 600px;
        display: inline-block;
    }
    </style>
</head>

<body>
<div id="swagger-ui"></div>

<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-bundle.js') }}"></script>
<script src="{{ l5_swagger_asset($documentation, 'swagger-ui-standalone-preset.js') }}"></script>
<script>
    window.onload = function() {
        // Build a system
        const ui = SwaggerUIBundle({
            dom_id: '#swagger-ui',
            url: "{!! $urlToDocs !!}",
            operationsSorter: {!! isset($operationsSorter) ? '"' . $operationsSorter . '"' : 'null' !!},
            configUrl: {!! isset($configUrl) ? '"' . $configUrl . '"' : 'null' !!},
            validatorUrl: {!! isset($validatorUrl) ? '"' . $validatorUrl . '"' : 'null' !!},
            oauth2RedirectUrl: "{{ route('l5-swagger.'.$documentation.'.oauth2_callback', [], $useAbsolutePath) }}",

            requestInterceptor: function(request) {
                request.headers['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
                return request;
            },

            presets: [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],

            plugins: [
                SwaggerUIBundle.plugins.DownloadUrl
            ],

            layout: "StandaloneLayout",
            docExpansion : "{!! config('l5-swagger.defaults.ui.display.doc_expansion', 'none') !!}",
            deepLinking: true,
            filter: {!! config('l5-swagger.defaults.ui.display.filter') ? 'true' : 'false' !!},
            persistAuthorization: "{!! config('l5-swagger.defaults.ui.authorization.persist_authorization') ? 'true' : 'false' !!}",

        })

        window.ui = ui

        @if(in_array('oauth2', array_column(config('l5-swagger.defaults.securityDefinitions.securitySchemes'), 'type')))
        ui.initOAuth({
            usePkceWithAuthorizationCodeGrant: "{!! (bool)config('l5-swagger.defaults.ui.authorization.oauth2.use_pkce_with_authorization_code_grant') !!}"
        })
        @endif
    }
</script>
<script defer>
    // 표 커스텀
    const interval = setInterval(() => {
        try {
            const myAccordion = document.querySelector('#myAccordion');

            // 1번 아코디언 요소
            const myItem1 = document.querySelector('#myItem1');
            const myHeader1 = document.querySelector('#myHeader1');
            const myButton1 = document.querySelector('#myButton1');
            const myCol1 = document.querySelector('#myCol1');
            const myColBody1 = document.querySelector('#myColBody1');
            const myTable = document.querySelector('#myTable');

            // 2번 아코디언 요소
            const myItem2 = document.querySelector('#myItem2');
            const myHeader2 = document.querySelector('#myHeader2');
            const myButton2 = document.querySelector('#myButton2');
            const myColBody2 = document.querySelector('#myColBody2');
            const myCol2 = document.querySelector('#myCol2');
            const jwtHeader2 = document.querySelector('#jwtHeader2');
            const jwtPayload2 = document.querySelector('#jwtPayload2');

            // 3번 아코디언 요소
            const myItem3 = document.querySelector('#myItem3');
            const myHeader3 = document.querySelector('#myHeader3');
            const myButton3 = document.querySelector('#myButton3');
            const myColBody3 = document.querySelector('#myColBody3');
            const myCol3 = document.querySelector('#myCol3');
            const jwtHeader3 = document.querySelector('#jwtHeader3');
            const jwtPayload3 = document.querySelector('#jwtPayload3');

            if(myTable) {
                myAccordion.classList = 'accordion';

                // 1번 아코디언
                myItem1.classList = 'accordion-item';

                myHeader1.classList = 'accordion-header';

                myButton1.classList = 'accordion-button collapsed';
                myButton1.setAttribute('type', 'button');
                myButton1.setAttribute('data-bs-toggle', 'collapse');
                myButton1.setAttribute('data-bs-target', '#myCol1');
                myButton1.setAttribute('aria-expanded', 'false');
                myButton1.setAttribute('aria-controls', 'myCol1');

                myCol1.classList = 'accordion-collapse collapse';
                myCol1.setAttribute('aria-labelledby', 'myHeader1');
                myCol1.setAttribute('data-bs-parent', '#myAccordion');

                myColBody1.classList = 'accordion-body';

                myTable.classList = 'table table-striped';

                // 2번 아코디언
                myItem2.classList = 'accordion-item';

                myHeader2.classList = 'accordion-header';

                myButton2.classList = 'accordion-button collapsed';
                myButton2.setAttribute('type', 'button');
                myButton2.setAttribute('data-bs-toggle', 'collapse');
                myButton2.setAttribute('data-bs-target', '#myCol2');
                myButton2.setAttribute('aria-expanded', 'false');
                myButton2.setAttribute('aria-controls', 'myCol2');

                myCol2.classList = 'accordion-collapse collapse';
                myCol2.setAttribute('aria-labelledby', 'myHeader2');
                myCol2.setAttribute('data-bs-parent', '#myAccordion');

                myColBody2.classList = 'accordion-body';

                jwtHeader2.style.color = '#fb015b';

                jwtPayload2.style.color = '#d63aff';

                // 3번 아코디언
                myItem3.classList = 'accordion-item';

                myHeader3.classList = 'accordion-header';

                myButton3.classList = 'accordion-button collapsed';
                myButton3.setAttribute('type', 'button');
                myButton3.setAttribute('data-bs-toggle', 'collapse');
                myButton3.setAttribute('data-bs-target', '#myCol3');
                myButton3.setAttribute('aria-expanded', 'false');
                myButton3.setAttribute('aria-controls', 'myCol3');

                myCol3.classList = 'accordion-collapse collapse';
                myCol3.setAttribute('aria-labelledby', 'myHeader3');
                myCol3.setAttribute('data-bs-parent', '#myAccordion');

                myColBody3.classList = 'accordion-body';

                jwtHeader3.style.color = '#fb015b';

                jwtPayload3.style.color = '#d63aff';

                // 이벤트 클리어
                clearInterval(interval);
            }
        } catch (error) {
            console.log('test5');
            console.log(error);
        }
    }, 500);
</script>
</body>
</html>
