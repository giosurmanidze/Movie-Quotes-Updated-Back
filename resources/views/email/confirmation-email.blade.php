<!DOCTYPE html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style>
        @media screen and (max-width: 525px) {
            table[class="wrapper"] {
                width: 100% !important;
            }

            td[class="mobile-hide"] {
                display: none;
            }

            img[class="mobile-hide"] {
                display: none !important;
            }

            img[class="img-max"] {
                max-width: 100% !important;
                height: auto !important;
            }

            table[class="responsive-table"] {
                width: 100% !important;
            }

            td[class="padding"] {
                padding: 10px 5% 15px 5% !important;
            }

            td[class="padding-copy"] {
                padding: 10px 5% 10px 5% !important;
                text-align: center;
            }

            td[class="padding-meta"] {
                padding: 30px 5% 0px 5% !important;
                text-align: center;
            }

            td[class="desk-button"] {
                width: 300px;
                height: 50px;
            }

            table[class="responsive-table"] {
                width: 100% !important;
            }

            td[class="no-padding"] {
                padding: 0 !important;
            }

            td[class="section-padding"] {
                padding: 50px 15px 50px 15px !important;
            }

            td[class="section-padding-bottom-image"] {
                padding: 50px 15px 0 15px !important;
            }

            td[class="mobile-wrapper"] {
                padding: 10px 5% 15px 5% !important;
            }

            table[class="mobile-button-container"] {
                margin: 0 auto;
                width: 100% !important;
            }

            a[class="mobile-button"] {
                width: 80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 16px !important;
            }
        }
    </style>
</head>

<body>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>

            <td bgcolor="#ffffff" align="center" style="padding: 70px 15px 70px 15px;">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="500"
                    class="responsive-table">
                    <td>
                        <table role="presentation" width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>
                                    <table role="presentation" width="100%" border="0" cellspacing="0"
                                        cellpadding="0">
                                        <tbody>
                                            <tr>
                                                <td class="padding-copy">
                                                    <table role="presentation" width="100%" border="0"
                                                        cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <img src="https://i.postimg.cc/fLfNcTq0/Landing-Worldwide-2.png"
                                                                    width="500" height="200" border="0"
                                                                    alt="Can an email really be responsive?"
                                                                    style="display: block; width: 100%; height: auto;"
                                                                    class="img-max">
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"
                                    style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;"
                                    class="padding-copy">
                                    <strong>{{ __('confirmation_email') }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td align="center"
                                    style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;"
                                    class="padding-copy">
                                    {{ __('conf_btn') }}
                                </td>
                            </tr>
                            <tr>
                                <td align="center" style="padding: 25px 0 0 0;" class="padding-copy">
                                    <table role="presentation" border="0" cellspacing="0" cellpadding="0"
                                        class="responsive-table">
                                        <tr>
                                            <td align="center">
                                                <a href="{{ $confirmationLink }}" target="_blank"
                                                    style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: white; text-decoration: none; background-color: #0FBA68; border-top: 15px solid #0FBA68; border-bottom: 15px solid #0FBA68; border-left: 120px solid #0FBA68; border-right: 120px solid #0FBA68; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;"
                                                    class="mobile-button desk-button">
                                                    {{ __('verify_btn') }}
                                                </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </td>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>