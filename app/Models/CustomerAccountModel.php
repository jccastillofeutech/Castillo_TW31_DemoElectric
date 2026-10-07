<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerAccountModel extends Model
{
    protected $table = 'customer_accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['account_number', 'customer_name', 'address', 'phone', 'email', 'meter_number', 'connection_type', 'status'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'account_number' => 'required|alpha_numeric_punct|max_length[50]',
        'customer_name' => 'required|min_length[2]|max_length[150]',
        'address' => 'required|max_length[255]',
        'phone' => 'required|max_length[30]',
        'email' => 'required|valid_email|max_length[150]',
        'meter_number' => 'required|max_length[50]',
        'connection_type' => 'required|in_list[residential,commercial,industrial]',
        'status' => 'required|in_list[active,inactive,suspended]',
    ];

    public function nextAccountNumber(?int $year = null): string
    {
        $year ??= (int) date('Y');
        $prefix = 'EC-' . $year . '-';
        $usedNumbers = [];

        $rows = $this->select('account_number')
            ->like('account_number', $prefix, 'after')
            ->findAll();

        foreach ($rows as $row) {
            $accountNumber = (string) ($row['account_number'] ?? '');

            if (preg_match('/^EC-' . $year . '-(\d{4})$/', $accountNumber, $matches)) {
                $usedNumbers[(int) $matches[1]] = true;
            }
        }

        for ($number = 1; $number <= 9999; $number++) {
            if (! isset($usedNumbers[$number])) {
                return $prefix . str_pad((string) $number, 4, '0', STR_PAD_LEFT);
            }
        }

        throw new \RuntimeException('No account numbers remain for ' . $year . '.');
    }

    public function filtered(?string $keyword, ?string $status, ?string $type, int $perPage = 10): array
    {
        if ($keyword) {
            $this->groupStart()->like('account_number', $keyword)->orLike('customer_name', $keyword)->orLike('email', $keyword)->orLike('phone', $keyword)->groupEnd();
        }
        if ($status) $this->where('status', $status);
        if ($type) $this->where('connection_type', $type);
        return $this->orderBy('created_at', 'DESC')->paginate($perPage);
    }

    public function countStatus(string $status): int
    {
        return $this->where('status', $status)->countAllResults();
    }
}
