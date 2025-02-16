# VulnDrake

<img src="assets/vulndrake-icon.png" alt="vulndrake-icon" width="100" height="100"/>

VulnDrake is a web-based vulnerability scanning and management application that integrates with OpenVAS to provide comprehensive security assessments.

## Features

- **Manual Scan**
    - Scan options :
        - All TCP ports (+65500) + top 100 UDP ports used by `nmap` **(default option)**.
        - All TCP ports (+5800) assigned by [IANA](https://www.iana.org).
        - All TCP (+5800) and UDP (+5482) ports assigned by [IANA](https://www.iana.org).

- **Scan History**
    - Access a history of previous scan reports.
    - Download reports in PDF format.

## Prerequisites

- [`docker`](https://docs.docker.com/engine/install/)
- [`docker-compose`](https://docs.docker.com/compose/install/linux/)

## Overview

![vulndrake](assets/vulndrake.png)

## Usage

Deploy VulnDrake :

```bash
sudo docker compose up -d
```

## Configuration

Renew the self-signed certificate :

```bash
cd nginx/

./renew-cert.sh
```