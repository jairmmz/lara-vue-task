<!DOCTYPE html>
<html lang="es">

  <head>
    <title>App Task - Verified email</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style type="text/css">
      #outlook a {
        padding: 0;
      }

      .ReadMsgBody {
        width: 100%;
      }

      .ExternalClass {
        width: 100%;
      }

      .ExternalClass * {
        line-height: 100%;
      }

      body {
        margin: 0;
        padding: 0;
        -webkit-text-size-adjust: 100%;
        -ms-text-size-adjust: 100%;
      }

      table,
      td {
        border-collapse: collapse;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
      }

      img {
        border: 0;
        height: auto;
        line-height: 100%;
        outline: none;
        text-decoration: none;
        -ms-interpolation-mode: bicubic;
      }

      p {
        display: block;
        margin: 13px 0;
      }
    </style>
    <style type="text/css">
      @media only screen and (max-width: 480px) {
        @-ms-viewport {
          width: 320px;
        }
        @viewport {
          width: 320px;
        }
      }
    </style>

    <style type="text/css">
      @media only screen and (min-width: 480px) {
        .mj-column-per-100 {
          width: 100% !important;
        }
      }
    </style>

    <style type="text/css"></style>
  </head>

  <body style="background-color: #f9f9f9">
    <div style="background-color: #f9f9f9">
      <div
        style="
          background: #f9f9f9;
          background-color: #f9f9f9;
          margin: 0px auto;
          max-width: 600px;
        "
      >
        <table
          align="center"
          border="0"
          cellpadding="0"
          cellspacing="0"
          role="presentation"
          style="background: #f9f9f9; background-color: #f9f9f9; width: 100%"
        >
          <tbody>
            <tr>
              <td
                style="
                  border-bottom: #333957 solid 5px;
                  direction: ltr;
                  font-size: 0px;
                  padding: 20px 0;
                  text-align: center;
                  vertical-align: top;
                "
              >
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div
        style="
          background: #fff;
          background-color: #fff;
          margin: 0px auto;
          max-width: 600px;
        "
      >
        <table
          align="center"
          border="0"
          cellpadding="0"
          cellspacing="0"
          role="presentation"
          style="background: #fff; background-color: #fff; width: 100%"
        >
          <tbody>
            <tr>
              <td
                style="
                  border: #dddddd solid 1px;
                  border-top: 0px;
                  direction: ltr;
                  font-size: 0px;
                  padding: 20px 0;
                  text-align: center;
                  vertical-align: top;
                "
              >

                <div
                  class="mj-column-per-100 outlook-group-fix"
                  style="
                    font-size: 13px;
                    text-align: left;
                    direction: ltr;
                    display: inline-block;
                    vertical-align: bottom;
                    width: 100%;
                  "
                >
                  <table
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    role="presentation"
                    style="vertical-align: bottom"
                    width="100%"
                  >

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          padding-bottom: 40px;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 32px;
                            font-weight: bold;
                            line-height: 1;
                            text-align: center;
                            color: #555;
                          "
                        >
                        Por favor, confirme su correo electrónico
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          padding-bottom: 20px;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 16px;
                            line-height: 22px;
                            text-align: center;
                            color: #555;
                          "
                        >
                        Hola, por favor valide su dirección de correo electrónico {{ $user->email }} para comenzar a usar la aplicación.
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          padding-top: 30px;
                          padding-bottom: 40px;
                          word-break: break-word;
                        "
                      >
                        <table
                          align="center"
                          border="0"
                          cellpadding="0"
                          cellspacing="0"
                          role="presentation"
                          style="border-collapse: separate; line-height: 100%"
                        >
                          <tr>
                            <td
                              align="center"
                              role="presentation"
                              
                            >
                              <a href="{{ route('check_email', ['token' => $user->remember_token]) }}"
                                style="
                                  background: #2f67f6;
                                  color: #ffffff;
                                  font-size: 16px;
                                  text-decoration: none;
                                  padding: 10px;
                                  border: none;
                                  cursor: pointer;
                                  border-radius: 5px;
                                "
                              >
                              Confirmar correo
                            </a>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          padding-bottom: 0;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 16px;
                            line-height: 22px;
                            text-align: center;
                            color: #555;
                          "
                        >
                            O verificar usando este enlace:
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          padding-bottom: 40px;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 16px;
                            line-height: 22px;
                            text-align: center;
                            color: #555;
                          "
                        >
                        <a href="{{ route('check_email', ['token' => $user->remember_token]) }}">
                            {{ route('check_email', ['token' => $user->remember_token]) }}
                        </a>
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 26px;
                            font-weight: bold;
                            line-height: 1;
                            text-align: center;
                            color: #555;
                          "
                        >
                          Necesitas ayuda?
                        </div>
                      </td>
                    </tr>

                    <tr>
                      <td
                        align="center"
                        style="
                          font-size: 0px;
                          padding: 10px 25px;
                          word-break: break-word;
                        "
                      >
                        <div
                          style="
                            font-family: 'Helvetica Neue', Arial, sans-serif;
                            font-size: 14px;
                            line-height: 22px;
                            text-align: center;
                            color: #555;
                          "
                        >
                        Por favor envienos un mensaje a:<br />
                          <a
                            href="mailto:info@example.com"
                            style="color: #2f67f6"
                            >info@example.com</a
                          >
                        </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div style="margin: 0px auto; max-width: 600px">
        <table
          align="center"
          border="0"
          cellpadding="0"
          cellspacing="0"
          role="presentation"
          style="width: 100%"
        >
          <tbody>
            <tr>
              <td
                style="
                  direction: ltr;
                  font-size: 0px;
                  padding: 20px 0;
                  text-align: center;
                  vertical-align: top;
                "
              >

                <div
                  class="mj-column-per-100 outlook-group-fix"
                  style="
                    font-size: 13px;
                    text-align: left;
                    direction: ltr;
                    display: inline-block;
                    vertical-align: bottom;
                    width: 100%;
                  "
                >
                  <table
                    border="0"
                    cellpadding="0"
                    cellspacing="0"
                    role="presentation"
                    width="100%"
                  >
                    <tbody>
                      <tr>
                        <td style="vertical-align: bottom; padding: 0">
                          <table
                            border="0"
                            cellpadding="0"
                            cellspacing="0"
                            role="presentation"
                            width="100%"
                          >
                            <tr>
                              <td
                                align="center"
                                style="
                                  font-size: 0px;
                                  padding: 0;
                                  word-break: break-word;
                                "
                              >
                                <div
                                  style="
                                    font-family: 'Helvetica Neue', Arial,
                                      sans-serif;
                                    font-size: 12px;
                                    font-weight: 300;
                                    line-height: 1;
                                    text-align: center;
                                    color: #575757;
                                  "
                                >
                                  App Task with Laravel 11 and Vue , Abancay. City 03001, PER
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td
                                align="center"
                                style="
                                  font-size: 0px;
                                  padding: 10px;
                                  word-break: break-word;
                                "
                              >
                                <div
                                  style="
                                    font-family: 'Helvetica Neue', Arial,
                                      sans-serif;
                                    font-size: 12px;
                                    font-weight: 300;
                                    line-height: 1;
                                    text-align: center;
                                    color: #575757;
                                  "
                                >
                                </div>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>
