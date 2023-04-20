@managing_suppliers
Feature: Adding a new supplier
    In order to show different brands
    As an Administrator
    I want to add a new supplier to the admin

    Background:
        Given I am logged in as an administrator
        And the store operates on a single channel in "United States"

    @ui
    Scenario: Adding a new supplier
        Given I want to add a new supplier
        When I fill the name with "Test"
        And I fill the slug with "test"
        And I fill the description with "This is a test"
        And I fill the email with "test@dameerv.com.ar"
        And I upload the "logo_dameerv.png" image
        And I add it
        Then I should be notified that it has been successfully created
        And the supplier "Test" should appear in the admin

    @ui
    Scenario: Trying to add a new supplier with empty fields
        Given I want to add a new supplier
        When I fill the name with "Test"
        And I add it
        Then I should be notified that the form contains invalid fields

    @ui
    Scenario: Trying to add a supplier with existing slug
        Given there is an existing supplier with "Test" name
        And I want to add a new supplier
        When I fill the slug with "test"
        And I add it
        Then I should be notified that there is already an existing supplier with provided slug
