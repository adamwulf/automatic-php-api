# Note: No longer works

See: http://community.automatic.com/automatic/topics/create_an_open_api#reply_13470182

Using Charles requires the connection to be re-encrypted with a non-Automatic SSL certificate, which is what allowed us to see the info as it passed through. But now that SSL connection is failing when "SSL Proxy" is checked in Charles, so there's no way for us to see the content that's going over the wire. 

Good news: Automatic is now more secure (was kinda surprised I ever could peek inside the SSL honestly!) 

Bad news: there's now no API option at all until they finally release an official version. Hopefully that's soon!

