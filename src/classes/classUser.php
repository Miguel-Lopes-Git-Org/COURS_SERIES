<?php

class User
{
    private string $email;
    private ?string $firstName;
    private ?string $lastName;
    private ?string $streetAddress;
    private ?string $zipCode;
    private ?string $city;
    private ?string $creditCardNumber;
    private ?string $creditCardExpirationDate;
    private ?string $phoneNumber;

    public function __construct(
        string $email,
        ?string $firstName,
        ?string $lastName,
        ?string $streetAddress,
        ?string $zipCode,
        ?string $city,
        ?string $creditCardNumber,
        ?string $creditCardExpirationDate,
        ?string $phoneNumber
    ) {
        try {
            $this->email = $email;
            $this->firstName = $firstName;
            $this->lastName = $lastName;
            $this->streetAddress = $streetAddress;
            $this->zipCode = $zipCode;
            $this->city = $city;
            $this->creditCardNumber = $creditCardNumber;
            $this->creditCardExpirationDate = $creditCardExpirationDate;
            $this->phoneNumber = $phoneNumber;
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }

    public function __destruct() {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getName(): array
    {
        return ["firstName" => $this->firstName, "lastName" => $this->lastName];
    }

    public function getLocalisation(): array
    {
        return ["streetAddress" => $this->streetAddress, "zipCode" => $this->zipCode, "city" => $this->city];
    }

    public function getCreditCard(): array
    {
        return ["number" => $this->creditCardNumber, "expirationDate" => $this->creditCardExpirationDate];
    }
}
