<?php

/*
 * Copyright (c) 2022-2024 Estonian Information System Authority
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

declare(strict_types=1);

namespace AppStoreServerLibrary\OCSP;

use phpseclib3\File\ASN1;
use phpseclib3\File\ASN1\Maps\Name;
use phpseclib3\File\X509;
use web_eid\ocsp_php\exceptions\OcspCertificateException;
use web_eid\ocsp_php\util\AsnUtil;

class Ocsp
{
    /**
     * The media type (Content-Type header) to be used when sending the request to the OCSP Responder URL.
     *
     * @var string
     */
    const OCSP_REQUEST_MEDIATYPE = "application/ocsp-request";

    /**
     * The media type (Content-Type header) that should be included in responses from the OCSP Responder URL.
     *
     * @var string
     */
    const OCSP_RESPONSE_MEDIATYPE = "application/ocsp-response";

    /**
     * Response type for a basic OCSP responder
     *
     * @var string
     */
    public const ID_PKIX_OCSP_BASIC_STRING = "id-pkix-ocsp-basic";

    /**
     * Generates certificate ID with subject and issuer certificates
     *
     * @param X509 $certificate - subject certificate
     * @param X509 $issuerCertificate - issuer certificate
     * @return mixed[]
     * @throws OcspCertificateException when the subject or issuer certificates don't have required data
     */
    public function generateCertificateId(
        X509 $certificate,
        X509 $issuerCertificate
    ): array {
        AsnUtil::loadOIDs();
        ASN1::loadOIDs(["id-sha256" => "2.16.840.1.101.3.4.2.1"]);

        $certificateId = [
            "hashAlgorithm" => [],
            "issuerNameHash" => "",
            "issuerKeyHash" => "",
            "serialNumber" => [],
        ];

        if (
            !isset(
                $certificate->getCurrentCert()["tbsCertificate"]["serialNumber"]
            )
        ) {
            // Serial number of subject certificate does not exist
            throw new OcspCertificateException(
                "Serial number of subject certificate does not exist"
            );
        }

        $certificateId["serialNumber"] = clone $certificate->getCurrentCert()[
            "tbsCertificate"
        ]["serialNumber"];

        // issuer name
        if (
            !isset(
                $issuerCertificate->getCurrentCert()["tbsCertificate"][
                    "subject"
                ]
            )
        ) {
            // Serial number of issuer certificate does not exist
            throw new OcspCertificateException(
                "Serial number of issuer certificate does not exist"
            );
        }

        $issuer = $issuerCertificate->getCurrentCert()["tbsCertificate"][
            "subject"
        ];
        $issuerEncoded = ASN1::encodeDER($issuer, Name::MAP);
        $certificateId["issuerNameHash"] = hash("sha256", $issuerEncoded, true);

        // issuer public key
        if (
            !isset(
                $issuerCertificate->getCurrentCert()["tbsCertificate"][
                    "subjectPublicKeyInfo"
                ]["subjectPublicKey"]
            )
        ) {
            // SubjectPublicKey of issuer certificate does not exist
            throw new OcspCertificateException(
                "SubjectPublicKey of issuer certificate does not exist"
            );
        }

        $publicKey = $issuerCertificate->getCurrentCert()["tbsCertificate"][
            "subjectPublicKeyInfo"
        ]["subjectPublicKey"];
        $certificateId["issuerKeyHash"] = hash(
            "sha256",
            AsnUtil::extractKeyData($publicKey),
            true
        );

        $certificateId["hashAlgorithm"]["algorithm"] = Asn1::getOID("id-sha256");

        return $certificateId;
    }
}
