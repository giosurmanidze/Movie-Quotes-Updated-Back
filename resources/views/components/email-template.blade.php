<div style="background-color: #0D0B14; height: 100%; width: 100%">
    <div style="padding: 40px">
        <table style="align-items: center; text-align: center; width: 100%">
            <tr>
                <td style="align-items: center; text-align: center">
                    {{-- <img src="{{ $message->e mbed(public_path('images/bi_chat-quote-fill.svg')) }}" title="Quote Icon" /> --}}
                    <p style="color: #DDCCAA">MOVIE QUOTES</p>
                </td>
            </tr>
        </table>
        <br />
        <br />
        <table>
            <tr>
                <td style="color: white">Holla {{ $name }}!</td>
            </tr>
            <br />
            <tr>
                <td style="color: white; margin-top: 4px; margin-bottom: 4px"> If clicking doesn't work, you can try
                    copying
                    and pasting it to your browser:</td>
            </tr>
            <br />
            <tr>
                <td>
                    <a href="{{ $url }}"
                        style="text-decoration: none; padding: 10px; border-radius: 6px;  color: white; background-color: #E31221;">
                        Verify account
                    </a>
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <p style="color: white">
                        If clicking doesn't work, you can try copying and pasting it to your browser:
                    </p>
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    {{ $url }}
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <p style="color: white">
                        If you have any problems, please contact us: {{ $url }}
                    </p>
                </td>
            </tr>
            <br />
            <tr>
                <td>
                    <p style="color: white">MovieQuotes crew</p>
                </td>
            </tr>
        </table>
    </div>
</div>
