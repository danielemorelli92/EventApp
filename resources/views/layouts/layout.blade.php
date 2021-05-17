<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EventApp</title>
    @yield('style')
</head>
<body>

<div class="whole-page-two-columns">
            <div class="header" data-position="inline" style="width: 100%">
                <table>
                    <tr>
                        <th><h1 style="display: inline; margin: 12px; float:left;">EventsApp</h1></th>
                        <th><input style="display: block; float:left;" type="button" value="home"></th>
                        <th><input style="display: block; float:left;" type="button" value="In evidenza"></th>
                        <th><input style="display: block; float:left;" type="button" value="Esplora"></th>
                        <th><input style="display: block; float:left;" type="button" value="Form"></th>
                        <th style="width: 100%"></th> <!-- spacer -->
                        <th><input style="display: inline; margin-right: 12px; float:left;" type="button" value="Login"></th>
                    </tr>
                </table>
            </div>
    @yield('content')
</div>



</body>
</html>
