<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Promotion Announcement</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <style>
      @media (max-width: 600px) {
        .logo {
          max-width: 200px;
          max-height: 200px;
        }
      }
      @media (max-width: 425px) {
        .logo {
          max-width: 150px;
          max-height: 150px;
        }
      }
      @media (max-width: 375px) {
        .logo-td{
          padding-top: 10px !important;
        }
        .logo {
          max-width: 125px;
          max-height: 125px;
        }
      }
      @media (max-width: 320px) {
        .logo {
          max-width: 110px;
          max-height: 110px;
        }
      }
    </style>
  </head>
  <body>
    <table class="confirmation" border="0" cellpadding="0" cellspacing="0" align="center" style="width: 95%; max-width: 600px; background: #f8fcfe" >
      <thead style="background-image: url('{{ asset('/images/header-bg.png') }}'); background-repeat: no-repeat; background-size: 100%; text-align: center; background-position: top;">
        <tr rowspan="12">
          <td colspan="12" class="logo-td" style="text-align: center; padding-top: 20px; padding-bottom: 0px" >
            <img src="{{ asset('/images/logo.png') }}" class="logo" style="width: 205px; height: 205px; object-fit: contain" />
          </td>
        </tr>
      </thead>
      <tbody align="center">
        <tr rowspan="12">
          <td colspan="12">
            <p style=" font-size: 16px; color: #333333; font-weight: 400; font-family: Arial; line-height: 25px; width: 80%; padding: 15px 0 5px 0; margin: 0 auto;">
              Dear {!! $name !!},
            </p>
          </td>
        </tr>
        <tr rowspan="12">
          <td colspan="12">
            <p style=" font-size: 16px; color: #333333; font-weight: 400; font-family: Arial; line-height: 25px; width: 80%; padding: 5px 0 50px 0; margin: 0 auto;">
              {!! $body !!}
            </p>
          </td>
        </tr>
      </tbody>
      <tfoot style="text-align: center">
        <tr rowspan="12">
          <td colspan="12"> <p style="border-top: 1px solid #e1e1e1; font-size: 16px; color: #444444; font-weight: 400; font-family: Arial; margin: 0 auto; padding-top: 37px;">
              Best Regards,
            </p>
          </td>
        </tr>
        <tr rowspan="12">
          <td colspan="12">
            <p style=" font-size: 16px; color: #444444; font-weight: 400; font-family: Arial; margin: 0 auto; padding-top: 8px;">
              The <b>{!! config('app.name') !!}</b>
            </p>
          </td>
        </tr>
        <tr rowspan="12">
          <td colspan="12" style="padding-top: 34px; padding-bottom: 40px">
            <a href="javascript:void(0);" style="text-decoration: none;">
                <img style="margin-right: 20px" src="{{ asset('/images/facebook.png') }}" alt="Facebook" />
            </a>
            <a href="javascript:void(0);" style="text-decoration: none;">
                <img style="margin-right: 20px" src="{{ asset('/images/x.png') }}" alt="Instagram" />
            </a>
            <a href="javascript:void(0);" style="text-decoration: none;">
                <img style="margin-right: 20px" src="{{ asset('/images/instagram.png') }}" alt="LinkedIn" />
            </a>
            <a href="javascript:void(0);" style="text-decoration: none;">
                <img style="margin-right: 20px" src="{{ asset('/images/youtube.png') }}" alt="YouTube" />
            </a>
            <a href="javascript:void(0);" style="text-decoration: none;">
              <img src="{{ asset('/images/linkedin.png') }}" alt="Twitter" />
            </a>
          </td>
        </tr>
      </tfoot>
    </table>
  </body>
</html>